package pe.edu.upeu.agreements.service;

import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import pe.edu.upeu.agreements.dto.FacultadDTO;
import pe.edu.upeu.agreements.entity.Facultad;
import pe.edu.upeu.agreements.mapper.FacultadMapper;
import pe.edu.upeu.agreements.repository.FacultadRepository;

import java.util.List;
import java.util.Optional;

/**
 * Service class for Facultad operations
 * 
 * @author UPeU Development Team
 */
@Service
@RequiredArgsConstructor
@Slf4j
@Transactional(readOnly = true)
public class FacultadService {

    private final FacultadRepository facultadRepository;
    private final FacultadMapper facultadMapper;

    /**
     * Get all faculties
     */
    public List<FacultadDTO> findAll() {
        log.debug("Finding all facultades");
        List<Facultad> facultades = facultadRepository.findAll();
        return facultadMapper.toDTOList(facultades);
    }

    /**
     * Find faculty by ID
     */
    public Optional<FacultadDTO> findById(Long id) {
        log.debug("Finding facultad by id: {}", id);
        return facultadRepository.findById(id)
                .map(facultadMapper::toDTO);
    }

    /**
     * Search faculties by name
     */
    public List<FacultadDTO> findByNombre(String nombre) {
        log.debug("Finding facultades by nombre: {}", nombre);
        List<Facultad> facultades = facultadRepository.findByNombreFacultadContainingIgnoreCase(nombre);
        return facultadMapper.toDTOList(facultades);
    }

    /**
     * Create new faculty
     */
    @Transactional
    public FacultadDTO create(FacultadDTO facultadDTO) {
        log.debug("Creating new facultad: {}", facultadDTO);
        
        // Check if faculty with same name already exists
        Optional<Facultad> existingFacultad = facultadRepository.findByNombreFacultad(facultadDTO.getNombreFacultad());
        if (existingFacultad.isPresent()) {
            throw new IllegalArgumentException("Ya existe una facultad con el nombre: " + facultadDTO.getNombreFacultad());
        }
        
        Facultad facultad = facultadMapper.toEntity(facultadDTO);
        Facultad savedFacultad = facultadRepository.save(facultad);
        log.info("Created facultad with id: {}", savedFacultad.getId());
        
        return facultadMapper.toDTO(savedFacultad);
    }

    /**
     * Update existing faculty
     */
    @Transactional
    public FacultadDTO update(Long id, FacultadDTO facultadDTO) {
        log.debug("Updating facultad with id: {} - data: {}", id, facultadDTO);
        
        Facultad facultad = facultadRepository.findById(id)
                .orElseThrow(() -> new IllegalArgumentException("Facultad no encontrada con id: " + id));
        
        // Check if another faculty with same name already exists
        Optional<Facultad> existingFacultad = facultadRepository.findByNombreFacultad(facultadDTO.getNombreFacultad());
        if (existingFacultad.isPresent() && !existingFacultad.get().getId().equals(id)) {
            throw new IllegalArgumentException("Ya existe otra facultad con el nombre: " + facultadDTO.getNombreFacultad());
        }
        
        facultad.setNombreFacultad(facultadDTO.getNombreFacultad());
        Facultad updatedFacultad = facultadRepository.save(facultad);
        log.info("Updated facultad with id: {}", updatedFacultad.getId());
        
        return facultadMapper.toDTO(updatedFacultad);
    }

    /**
     * Delete faculty
     */
    @Transactional
    public void delete(Long id) {
        log.debug("Deleting facultad with id: {}", id);
        
        if (!facultadRepository.existsById(id)) {
            throw new IllegalArgumentException("Facultad no encontrada con id: " + id);
        }
        
        facultadRepository.deleteById(id);
        log.info("Deleted facultad with id: {}", id);
    }

    /**
     * Check if faculty exists
     */
    public boolean existsById(Long id) {
        return facultadRepository.existsById(id);
    }
}