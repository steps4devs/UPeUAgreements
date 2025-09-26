package pe.edu.upeu.agreements.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import pe.edu.upeu.agreements.entity.Carrera;

import java.util.List;
import java.util.Optional;

/**
 * Repository interface for Carrera entity
 * 
 * @author UPeU Development Team
 */
@Repository
public interface CarreraRepository extends JpaRepository<Carrera, Long> {
    
    /**
     * Find careers by faculty ID
     */
    List<Carrera> findByFacultadId(Long facultadId);
    
    /**
     * Find career by name containing the given text (case insensitive)
     */
    List<Carrera> findByNombreCarreraContainingIgnoreCase(String nombre);
    
    /**
     * Find career by exact name and faculty ID
     */
    Optional<Carrera> findByNombreCarreraAndFacultadId(String nombreCarrera, Long facultadId);
}