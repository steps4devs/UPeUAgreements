package pe.edu.upeu.agreements.mapper;

import org.mapstruct.Mapper;
import org.mapstruct.Mapping;
import org.mapstruct.MappingTarget;
import pe.edu.upeu.agreements.dto.EntidadDTO;
import pe.edu.upeu.agreements.dto.request.EntidadRequestDTO;
import pe.edu.upeu.agreements.entity.Entidad;

import java.util.List;

/**
 * MapStruct mapper for Entidad entity
 * 
 * @author UPeU Development Team
 */
@Mapper(componentModel = "spring")
public interface EntidadMapper {
    
    /**
     * Convert Entidad entity to EntidadDTO
     */
    EntidadDTO toDTO(Entidad entidad);
    
    /**
     * Convert list of Entidad entities to list of EntidadDTOs
     */
    List<EntidadDTO> toDTOList(List<Entidad> entidades);
    
    /**
     * Convert EntidadRequestDTO to Entidad entity
     */
    @Mapping(target = "id", ignore = true)
    @Mapping(target = "createdAt", ignore = true)
    @Mapping(target = "updatedAt", ignore = true)
    @Mapping(target = "convenios", ignore = true)
    Entidad toEntity(EntidadRequestDTO entidadRequestDTO);
    
    /**
     * Update existing Entidad entity from EntidadRequestDTO
     */
    @Mapping(target = "id", ignore = true)
    @Mapping(target = "createdAt", ignore = true)
    @Mapping(target = "updatedAt", ignore = true)
    @Mapping(target = "convenios", ignore = true)
    void updateEntity(EntidadRequestDTO entidadRequestDTO, @MappingTarget Entidad entidad);
}