package pe.edu.upeu.agreements.service;

import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import pe.edu.upeu.agreements.dto.EntidadDTO;
import pe.edu.upeu.agreements.dto.request.EntidadRequestDTO;
import pe.edu.upeu.agreements.entity.Entidad;
import pe.edu.upeu.agreements.mapper.EntidadMapper;
import pe.edu.upeu.agreements.repository.EntidadRepository;

import java.util.List;
import java.util.Optional;

/**
 * Service class for Entidad operations
 * 
 * @author UPeU Development Team
 */
@Service
@RequiredArgsConstructor
@Slf4j
@Transactional(readOnly = true)
public class EntidadService {

    private final EntidadRepository entidadRepository;
    private final EntidadMapper entidadMapper;

    /**
     * Get all entities
     */
    public List<EntidadDTO> findAll() {
        log.debug("Finding all entidades");
        List<Entidad> entidades = entidadRepository.findAll();
        return entidadMapper.toDTOList(entidades);
    }

    /**
     * Get all entities with pagination
     */
    public Page<EntidadDTO> findAll(Pageable pageable) {
        log.debug("Finding all entidades with pagination: {}", pageable);
        Page<Entidad> entidades = entidadRepository.findAll(pageable);
        return entidades.map(entidadMapper::toDTO);
    }

    /**
     * Find entity by ID
     */
    public Optional<EntidadDTO> findById(Long id) {
        log.debug("Finding entidad by id: {}", id);
        return entidadRepository.findById(id)
                .map(entidadMapper::toDTO);
    }

    /**
     * Search entities by name
     */
    public List<EntidadDTO> findByNombre(String nombre) {
        log.debug("Finding entidades by nombre: {}", nombre);
        List<Entidad> entidades = entidadRepository.findByNombreEntidadContainingIgnoreCase(nombre);
        return entidadMapper.toDTOList(entidades);
    }

    /**
     * Search entities by multiple criteria
     */
    public List<EntidadDTO> findByMultipleCriteria(String nombre, String ubicacion, String contacto) {
        log.debug("Finding entidades by multiple criteria - nombre: {}, ubicacion: {}, contacto: {}", 
                 nombre, ubicacion, contacto);
        List<Entidad> entidades = entidadRepository.findByMultipleCriteria(nombre, ubicacion, contacto);
        return entidadMapper.toDTOList(entidades);
    }

    /**
     * Create new entity
     */
    @Transactional
    public EntidadDTO create(EntidadRequestDTO entidadRequestDTO) {
        log.debug("Creating new entidad: {}", entidadRequestDTO);
        
        // Check if entity with same name already exists
        Optional<Entidad> existingEntidad = entidadRepository.findByNombreEntidad(entidadRequestDTO.getNombreEntidad());
        if (existingEntidad.isPresent()) {
            throw new IllegalArgumentException("Ya existe una entidad con el nombre: " + entidadRequestDTO.getNombreEntidad());
        }
        
        Entidad entidad = entidadMapper.toEntity(entidadRequestDTO);
        Entidad savedEntidad = entidadRepository.save(entidad);
        log.info("Created entidad with id: {}", savedEntidad.getId());
        
        return entidadMapper.toDTO(savedEntidad);
    }

    /**
     * Update existing entity
     */
    @Transactional
    public EntidadDTO update(Long id, EntidadRequestDTO entidadRequestDTO) {
        log.debug("Updating entidad with id: {} - data: {}", id, entidadRequestDTO);
        
        Entidad entidad = entidadRepository.findById(id)
                .orElseThrow(() -> new IllegalArgumentException("Entidad no encontrada con id: " + id));
        
        // Check if another entity with same name already exists
        Optional<Entidad> existingEntidad = entidadRepository.findByNombreEntidad(entidadRequestDTO.getNombreEntidad());
        if (existingEntidad.isPresent() && !existingEntidad.get().getId().equals(id)) {
            throw new IllegalArgumentException("Ya existe otra entidad con el nombre: " + entidadRequestDTO.getNombreEntidad());
        }
        
        entidadMapper.updateEntity(entidadRequestDTO, entidad);
        Entidad updatedEntidad = entidadRepository.save(entidad);
        log.info("Updated entidad with id: {}", updatedEntidad.getId());
        
        return entidadMapper.toDTO(updatedEntidad);
    }

    /**
     * Delete entity
     */
    @Transactional
    public void delete(Long id) {
        log.debug("Deleting entidad with id: {}", id);
        
        if (!entidadRepository.existsById(id)) {
            throw new IllegalArgumentException("Entidad no encontrada con id: " + id);
        }
        
        entidadRepository.deleteById(id);
        log.info("Deleted entidad with id: {}", id);
    }

    /**
     * Check if entity exists
     */
    public boolean existsById(Long id) {
        return entidadRepository.existsById(id);
    }
}