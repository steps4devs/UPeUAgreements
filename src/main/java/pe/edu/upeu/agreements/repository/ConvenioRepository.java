package pe.edu.upeu.agreements.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;
import pe.edu.upeu.agreements.entity.Convenio;
import pe.edu.upeu.agreements.entity.enums.AlcanceConvenio;
import pe.edu.upeu.agreements.entity.enums.EstadoConvenio;

import java.time.LocalDate;
import java.util.List;

/**
 * Repository interface for Convenio entity
 * 
 * @author UPeU Development Team
 */
@Repository
public interface ConvenioRepository extends JpaRepository<Convenio, Long> {
    
    /**
     * Find agreements by state
     */
    List<Convenio> findByEstado(EstadoConvenio estado);
    
    /**
     * Find agreements by scope
     */
    List<Convenio> findByAlcance(AlcanceConvenio alcance);
    
    /**
     * Find agreements by entity ID
     */
    List<Convenio> findByEntidadId(Long entidadId);
    
    /**
     * Find agreements by faculty ID
     */
    List<Convenio> findByFacultadId(Long facultadId);
    
    /**
     * Find agreements by career ID
     */
    List<Convenio> findByCarreraId(Long carreraId);
    
    /**
     * Find agreements by creator user ID
     */
    List<Convenio> findByConvenioCreadorId(Long userId);
    
    /**
     * Find agreements expiring within a certain period
     */
    @Query("SELECT c FROM Convenio c WHERE c.fechaFin BETWEEN :startDate AND :endDate")
    List<Convenio> findExpiringBetween(@Param("startDate") LocalDate startDate, 
                                      @Param("endDate") LocalDate endDate);
    
    /**
     * Find agreements by name containing text (case insensitive)
     */
    List<Convenio> findByNombreConvenioContainingIgnoreCase(String nombre);
    
    /**
     * Complex search with multiple filters
     */
    @Query("SELECT c FROM Convenio c WHERE " +
           "(:nombre IS NULL OR LOWER(c.nombreConvenio) LIKE LOWER(CONCAT('%', :nombre, '%'))) AND " +
           "(:estado IS NULL OR c.estado = :estado) AND " +
           "(:alcance IS NULL OR c.alcance = :alcance) AND " +
           "(:entidadId IS NULL OR c.entidad.id = :entidadId) AND " +
           "(:facultadId IS NULL OR c.facultad.id = :facultadId)")
    List<Convenio> findByMultipleCriteria(@Param("nombre") String nombre,
                                         @Param("estado") EstadoConvenio estado,
                                         @Param("alcance") AlcanceConvenio alcance,
                                         @Param("entidadId") Long entidadId,
                                         @Param("facultadId") Long facultadId);
}