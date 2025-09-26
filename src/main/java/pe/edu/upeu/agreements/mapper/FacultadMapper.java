package pe.edu.upeu.agreements.mapper;

import org.mapstruct.Mapper;
import org.mapstruct.Mapping;
import pe.edu.upeu.agreements.dto.FacultadDTO;
import pe.edu.upeu.agreements.entity.Facultad;

import java.util.List;

/**
 * MapStruct mapper for Facultad entity
 * 
 * @author UPeU Development Team
 */
@Mapper(componentModel = "spring")
public interface FacultadMapper {
    
    /**
     * Convert Facultad entity to FacultadDTO
     */
    FacultadDTO toDTO(Facultad facultad);
    
    /**
     * Convert list of Facultad entities to list of FacultadDTOs
     */
    List<FacultadDTO> toDTOList(List<Facultad> facultades);
    
    /**
     * Convert FacultadDTO to Facultad entity
     */
    @Mapping(target = "createdAt", ignore = true)
    @Mapping(target = "updatedAt", ignore = true)
    @Mapping(target = "carreras", ignore = true)
    @Mapping(target = "convenios", ignore = true)
    Facultad toEntity(FacultadDTO facultadDTO);
}