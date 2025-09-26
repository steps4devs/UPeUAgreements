package pe.edu.upeu.agreements.mapper;

import org.mapstruct.Mapper;
import org.mapstruct.Mapping;
import org.mapstruct.MappingTarget;
import pe.edu.upeu.agreements.dto.ConvenioDTO;
import pe.edu.upeu.agreements.dto.request.ConvenioRequestDTO;
import pe.edu.upeu.agreements.entity.Convenio;

import java.util.List;

/**
 * MapStruct mapper for Convenio entity
 * 
 * @author UPeU Development Team
 */
@Mapper(componentModel = "spring", uses = {DocumentoConvenioMapper.class})
public interface ConvenioMapper {
    
    /**
     * Convert Convenio entity to ConvenioDTO
     */
    @Mapping(source = "convenioCreador.id", target = "convenioCreadorId")
    @Mapping(source = "convenioCreador.name", target = "nombreCreador")
    @Mapping(source = "entidad.id", target = "entidadId")
    @Mapping(source = "entidad.nombreEntidad", target = "nombreEntidad")
    @Mapping(source = "facultad.id", target = "facultadId")
    @Mapping(source = "facultad.nombreFacultad", target = "nombreFacultad")
    @Mapping(source = "carrera.id", target = "carreraId")
    @Mapping(source = "carrera.nombreCarrera", target = "nombreCarrera")
    ConvenioDTO toDTO(Convenio convenio);
    
    /**
     * Convert list of Convenio entities to list of ConvenioDTOs
     */
    List<ConvenioDTO> toDTOList(List<Convenio> convenios);
    
    /**
     * Convert ConvenioRequestDTO to Convenio entity
     */
    @Mapping(target = "id", ignore = true)
    @Mapping(target = "estado", ignore = true) // Estado is calculated in service
    @Mapping(target = "convenioCreador", ignore = true) // Set in service
    @Mapping(target = "entidad", ignore = true) // Set in service
    @Mapping(target = "facultad", ignore = true) // Set in service
    @Mapping(target = "carrera", ignore = true) // Set in service
    @Mapping(target = "createdAt", ignore = true)
    @Mapping(target = "updatedAt", ignore = true)
    @Mapping(target = "documentos", ignore = true)
    Convenio toEntity(ConvenioRequestDTO convenioRequestDTO);
    
    /**
     * Update existing Convenio entity from ConvenioRequestDTO
     */
    @Mapping(target = "id", ignore = true)
    @Mapping(target = "estado", ignore = true) // Estado is calculated in service
    @Mapping(target = "convenioCreador", ignore = true) // Don't change creator
    @Mapping(target = "entidad", ignore = true) // Set in service
    @Mapping(target = "facultad", ignore = true) // Set in service
    @Mapping(target = "carrera", ignore = true) // Set in service
    @Mapping(target = "createdAt", ignore = true)
    @Mapping(target = "updatedAt", ignore = true)
    @Mapping(target = "documentos", ignore = true)
    void updateEntity(ConvenioRequestDTO convenioRequestDTO, @MappingTarget Convenio convenio);
}