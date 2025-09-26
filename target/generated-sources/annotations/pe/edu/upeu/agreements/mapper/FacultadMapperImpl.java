package pe.edu.upeu.agreements.mapper;

import java.util.ArrayList;
import java.util.List;
import javax.annotation.processing.Generated;
import org.springframework.stereotype.Component;
import pe.edu.upeu.agreements.dto.FacultadDTO;
import pe.edu.upeu.agreements.entity.Facultad;

@Generated(
    value = "org.mapstruct.ap.MappingProcessor",
    date = "2025-09-26T20:50:29+0000",
    comments = "version: 1.5.5.Final, compiler: javac, environment: Java 17.0.16 (Eclipse Adoptium)"
)
@Component
public class FacultadMapperImpl implements FacultadMapper {

    @Override
    public FacultadDTO toDTO(Facultad facultad) {
        if ( facultad == null ) {
            return null;
        }

        FacultadDTO facultadDTO = new FacultadDTO();

        facultadDTO.setId( facultad.getId() );
        facultadDTO.setNombreFacultad( facultad.getNombreFacultad() );
        facultadDTO.setCreatedAt( facultad.getCreatedAt() );
        facultadDTO.setUpdatedAt( facultad.getUpdatedAt() );

        return facultadDTO;
    }

    @Override
    public List<FacultadDTO> toDTOList(List<Facultad> facultades) {
        if ( facultades == null ) {
            return null;
        }

        List<FacultadDTO> list = new ArrayList<FacultadDTO>( facultades.size() );
        for ( Facultad facultad : facultades ) {
            list.add( toDTO( facultad ) );
        }

        return list;
    }

    @Override
    public Facultad toEntity(FacultadDTO facultadDTO) {
        if ( facultadDTO == null ) {
            return null;
        }

        Facultad facultad = new Facultad();

        facultad.setId( facultadDTO.getId() );
        facultad.setNombreFacultad( facultadDTO.getNombreFacultad() );

        return facultad;
    }
}
