package pe.edu.upeu.agreements.service;

import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import pe.edu.upeu.agreements.dto.ConvenioDTO;
import pe.edu.upeu.agreements.dto.request.ConvenioRequestDTO;
import pe.edu.upeu.agreements.entity.*;
import pe.edu.upeu.agreements.entity.enums.EstadoConvenio;
import pe.edu.upeu.agreements.mapper.ConvenioMapper;
import pe.edu.upeu.agreements.repository.*;

import java.time.LocalDate;
import java.time.temporal.ChronoUnit;
import java.util.List;
import java.util.Optional;

/**
 * Service class for Convenio operations
 * 
 * @author UPeU Development Team
 */
@Service
@RequiredArgsConstructor
@Slf4j
@Transactional(readOnly = true)
public class ConvenioService {

    private final ConvenioRepository convenioRepository;
    private final EntidadRepository entidadRepository;
    private final FacultadRepository facultadRepository;
    private final CarreraRepository carreraRepository;
    private final UserRepository userRepository;
    private final ConvenioMapper convenioMapper;

    /**
     * Get all agreements
     */
    public List<ConvenioDTO> findAll() {
        log.debug("Finding all convenios");
        List<Convenio> convenios = convenioRepository.findAll();
        return convenioMapper.toDTOList(convenios);
    }

    /**
     * Get all agreements with pagination
     */
    public Page<ConvenioDTO> findAll(Pageable pageable) {
        log.debug("Finding all convenios with pagination: {}", pageable);
        Page<Convenio> convenios = convenioRepository.findAll(pageable);
        return convenios.map(convenioMapper::toDTO);
    }

    /**
     * Find agreement by ID
     */
    public Optional<ConvenioDTO> findById(Long id) {
        log.debug("Finding convenio by id: {}", id);
        return convenioRepository.findById(id)
                .map(convenioMapper::toDTO);
    }

    /**
     * Search agreements by name
     */
    public List<ConvenioDTO> findByNombre(String nombre) {
        log.debug("Finding convenios by nombre: {}", nombre);
        List<Convenio> convenios = convenioRepository.findByNombreConvenioContainingIgnoreCase(nombre);
        return convenioMapper.toDTOList(convenios);
    }

    /**
     * Find agreements expiring soon (within 30 days)
     */
    public List<ConvenioDTO> findExpiringSoon() {
        log.debug("Finding convenios expiring soon");
        LocalDate today = LocalDate.now();
        LocalDate thirtyDaysFromNow = today.plusDays(30);
        List<Convenio> convenios = convenioRepository.findExpiringBetween(today, thirtyDaysFromNow);
        return convenioMapper.toDTOList(convenios);
    }

    /**
     * Create new agreement
     */
    @Transactional
    public ConvenioDTO create(ConvenioRequestDTO convenioRequestDTO, Long creatorUserId) {
        log.debug("Creating new convenio: {} by user: {}", convenioRequestDTO, creatorUserId);
        
        // Validate entities exist
        User creator = userRepository.findById(creatorUserId)
                .orElseThrow(() -> new IllegalArgumentException("Usuario creador no encontrado con id: " + creatorUserId));
        
        Entidad entidad = entidadRepository.findById(convenioRequestDTO.getEntidadId())
                .orElseThrow(() -> new IllegalArgumentException("Entidad no encontrada con id: " + convenioRequestDTO.getEntidadId()));
        
        Facultad facultad = null;
        if (convenioRequestDTO.getFacultadId() != null) {
            facultad = facultadRepository.findById(convenioRequestDTO.getFacultadId())
                    .orElseThrow(() -> new IllegalArgumentException("Facultad no encontrada con id: " + convenioRequestDTO.getFacultadId()));
        }
        
        Carrera carrera = null;
        if (convenioRequestDTO.getCarreraId() != null) {
            carrera = carreraRepository.findById(convenioRequestDTO.getCarreraId())
                    .orElseThrow(() -> new IllegalArgumentException("Carrera no encontrada con id: " + convenioRequestDTO.getCarreraId()));
        }
        
        Convenio convenio = convenioMapper.toEntity(convenioRequestDTO);
        convenio.setConvenioCreador(creator);
        convenio.setEntidad(entidad);
        convenio.setFacultad(facultad);
        convenio.setCarrera(carrera);
        
        // Calculate status based on dates
        convenio.setEstado(calculateEstado(convenioRequestDTO.getFechaInicio(), convenioRequestDTO.getFechaFin()));
        
        Convenio savedConvenio = convenioRepository.save(convenio);
        log.info("Created convenio with id: {}", savedConvenio.getId());
        
        return convenioMapper.toDTO(savedConvenio);
    }

    /**
     * Update existing agreement
     */
    @Transactional
    public ConvenioDTO update(Long id, ConvenioRequestDTO convenioRequestDTO) {
        log.debug("Updating convenio with id: {} - data: {}", id, convenioRequestDTO);
        
        Convenio convenio = convenioRepository.findById(id)
                .orElseThrow(() -> new IllegalArgumentException("Convenio no encontrado con id: " + id));
        
        // Validate entities exist
        Entidad entidad = entidadRepository.findById(convenioRequestDTO.getEntidadId())
                .orElseThrow(() -> new IllegalArgumentException("Entidad no encontrada con id: " + convenioRequestDTO.getEntidadId()));
        
        Facultad facultad = null;
        if (convenioRequestDTO.getFacultadId() != null) {
            facultad = facultadRepository.findById(convenioRequestDTO.getFacultadId())
                    .orElseThrow(() -> new IllegalArgumentException("Facultad no encontrada con id: " + convenioRequestDTO.getFacultadId()));
        }
        
        Carrera carrera = null;
        if (convenioRequestDTO.getCarreraId() != null) {
            carrera = carreraRepository.findById(convenioRequestDTO.getCarreraId())
                    .orElseThrow(() -> new IllegalArgumentException("Carrera no encontrada con id: " + convenioRequestDTO.getCarreraId()));
        }
        
        convenioMapper.updateEntity(convenioRequestDTO, convenio);
        convenio.setEntidad(entidad);
        convenio.setFacultad(facultad);
        convenio.setCarrera(carrera);
        
        // Recalculate status based on dates
        convenio.setEstado(calculateEstado(convenioRequestDTO.getFechaInicio(), convenioRequestDTO.getFechaFin()));
        
        Convenio updatedConvenio = convenioRepository.save(convenio);
        log.info("Updated convenio with id: {}", updatedConvenio.getId());
        
        return convenioMapper.toDTO(updatedConvenio);
    }

    /**
     * Delete agreement
     */
    @Transactional
    public void delete(Long id) {
        log.debug("Deleting convenio with id: {}", id);
        
        if (!convenioRepository.existsById(id)) {
            throw new IllegalArgumentException("Convenio no encontrado con id: " + id);
        }
        
        convenioRepository.deleteById(id);
        log.info("Deleted convenio with id: {}", id);
    }

    /**
     * Calculate agreement status based on dates (mimicking Laravel logic)
     */
    private EstadoConvenio calculateEstado(LocalDate fechaInicio, LocalDate fechaFin) {
        if (fechaFin == null) {
            return EstadoConvenio.VIGENTE;
        }
        
        LocalDate today = LocalDate.now();
        
        if (fechaFin.isBefore(today)) {
            return EstadoConvenio.VENCIDO;
        }
        
        long daysUntilExpiry = ChronoUnit.DAYS.between(today, fechaFin);
        if (daysUntilExpiry <= 30) {
            return EstadoConvenio.POR_VENCER;
        }
        
        return EstadoConvenio.VIGENTE;
    }

    /**
     * Update all agreement statuses (can be called periodically)
     */
    @Transactional
    public void updateAllStatuses() {
        log.debug("Updating all convenio statuses");
        List<Convenio> convenios = convenioRepository.findAll();
        
        for (Convenio convenio : convenios) {
            EstadoConvenio newEstado = calculateEstado(convenio.getFechaInicio(), convenio.getFechaFin());
            if (!newEstado.equals(convenio.getEstado())) {
                convenio.setEstado(newEstado);
                convenioRepository.save(convenio);
                log.debug("Updated status for convenio id: {} to: {}", convenio.getId(), newEstado);
            }
        }
        
        log.info("Finished updating all convenio statuses");
    }

    /**
     * Check if agreement exists
     */
    public boolean existsById(Long id) {
        return convenioRepository.existsById(id);
    }
}