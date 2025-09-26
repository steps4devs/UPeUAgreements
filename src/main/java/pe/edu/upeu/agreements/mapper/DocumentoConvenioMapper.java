package pe.edu.upeu.agreements.mapper;

import org.mapstruct.Mapper;
import org.mapstruct.Mapping;
import pe.edu.upeu.agreements.dto.DocumentoConvenioDTO;
import pe.edu.upeu.agreements.entity.DocumentoConvenio;

import java.util.List;

/**
 * MapStruct mapper for DocumentoConvenio entity
 * 
 * @author UPeU Development Team
 */
@Mapper(componentModel = "spring")
public interface DocumentoConvenioMapper {
    
    /**
     * Convert DocumentoConvenio entity to DocumentoConvenioDTO
     */
    @Mapping(source = "convenio.id", target = "convenioId")
    @Mapping(source = "convenio.nombreConvenio", target = "nombreConvenio")
    DocumentoConvenioDTO toDTO(DocumentoConvenio documentoConvenio);
    
    /**
     * Convert list of DocumentoConvenio entities to list of DocumentoConvenioDTOs
     */
    List<DocumentoConvenioDTO> toDTOList(List<DocumentoConvenio> documentos);
    
    /**
     * Convert DocumentoConvenioDTO to DocumentoConvenio entity
     */
    @Mapping(target = "convenio", ignore = true) // Set in service
    @Mapping(target = "createdAt", ignore = true)
    @Mapping(target = "updatedAt", ignore = true)
    DocumentoConvenio toEntity(DocumentoConvenioDTO documentoConvenioDTO);
}