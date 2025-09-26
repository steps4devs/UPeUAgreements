package pe.edu.upeu.agreements.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;
import pe.edu.upeu.agreements.entity.Entidad;

import java.util.List;
import java.util.Optional;

/**
 * Repository interface for Entidad entity
 * 
 * @author UPeU Development Team
 */
@Repository
public interface EntidadRepository extends JpaRepository<Entidad, Long> {
    
    /**
     * Find entity by name containing the given text (case insensitive)
     */
    List<Entidad> findByNombreEntidadContainingIgnoreCase(String nombre);
    
    /**
     * Find entity by exact name
     */
    Optional<Entidad> findByNombreEntidad(String nombreEntidad);
    
    /**
     * Find entities by location containing the given text
     */
    List<Entidad> findByUbicacionContainingIgnoreCase(String ubicacion);
    
    /**
     * Custom query to search entities by multiple criteria
     */
    @Query("SELECT e FROM Entidad e WHERE " +
           "(:nombre IS NULL OR LOWER(e.nombreEntidad) LIKE LOWER(CONCAT('%', :nombre, '%'))) AND " +
           "(:ubicacion IS NULL OR LOWER(e.ubicacion) LIKE LOWER(CONCAT('%', :ubicacion, '%'))) AND " +
           "(:contacto IS NULL OR LOWER(e.contacto) LIKE LOWER(CONCAT('%', :contacto, '%')))")
    List<Entidad> findByMultipleCriteria(@Param("nombre") String nombre, 
                                        @Param("ubicacion") String ubicacion, 
                                        @Param("contacto") String contacto);
}