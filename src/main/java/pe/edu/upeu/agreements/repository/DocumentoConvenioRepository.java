package pe.edu.upeu.agreements.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import pe.edu.upeu.agreements.entity.DocumentoConvenio;

import java.util.List;

/**
 * Repository interface for DocumentoConvenio entity
 * 
 * @author UPeU Development Team
 */
@Repository
public interface DocumentoConvenioRepository extends JpaRepository<DocumentoConvenio, Long> {
    
    /**
     * Find documents by agreement ID
     */
    List<DocumentoConvenio> findByConvenioId(Long convenioId);
    
    /**
     * Find documents by filename containing text
     */
    List<DocumentoConvenio> findByNombreArchivoContainingIgnoreCase(String nombreArchivo);
}