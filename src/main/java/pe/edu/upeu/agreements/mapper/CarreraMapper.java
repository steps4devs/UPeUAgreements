package pe.edu.upeu.agreements.mapper;

import org.mapstruct.Mapper;
import org.mapstruct.Mapping;
import pe.edu.upeu.agreements.dto.CarreraDTO;
import pe.edu.upeu.agreements.entity.Carrera;

import java.util.List;

/**
 * MapStruct mapper for Carrera entity
 * 
 * @author UPeU Development Team
 */
@Mapper(componentModel = "spring")
public interface CarreraMapper {
    
    /**
     * Convert Carrera entity to CarreraDTO
     */
    @Mapping(source = "facultad.id", target = "facultadId")
    @Mapping(source = "facultad.nombreFacultad", target = "nombreFacultad")
    CarreraDTO toDTO(Carrera carrera);
    
    /**
     * Convert list of Carrera entities to list of CarreraDTOs
     */
    List<CarreraDTO> toDTOList(List<Carrera> carreras);
    
    /**
     * Convert CarreraDTO to Carrera entity
     */
    @Mapping(target = "facultad", ignore = true)
    @Mapping(target = "createdAt", ignore = true)
    @Mapping(target = "updatedAt", ignore = true)
    @Mapping(target = "convenios", ignore = true)
    Carrera toEntity(CarreraDTO carreraDTO);
}