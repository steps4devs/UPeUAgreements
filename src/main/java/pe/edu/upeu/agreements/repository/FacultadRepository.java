package pe.edu.upeu.agreements.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import pe.edu.upeu.agreements.entity.Facultad;

import java.util.List;
import java.util.Optional;

/**
 * Repository interface for Facultad entity
 * 
 * @author UPeU Development Team
 */
@Repository
public interface FacultadRepository extends JpaRepository<Facultad, Long> {
    
    /**
     * Find faculty by name containing the given text (case insensitive)
     */
    List<Facultad> findByNombreFacultadContainingIgnoreCase(String nombre);
    
    /**
     * Find faculty by exact name
     */
    Optional<Facultad> findByNombreFacultad(String nombreFacultad);
}