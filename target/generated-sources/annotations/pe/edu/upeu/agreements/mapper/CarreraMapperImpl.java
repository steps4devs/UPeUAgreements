package pe.edu.upeu.agreements.mapper;

import java.util.ArrayList;
import java.util.List;
import javax.annotation.processing.Generated;
import org.springframework.stereotype.Component;
import pe.edu.upeu.agreements.dto.CarreraDTO;
import pe.edu.upeu.agreements.entity.Carrera;
import pe.edu.upeu.agreements.entity.Facultad;

@Generated(
    value = "org.mapstruct.ap.MappingProcessor",
    date = "2025-09-26T20:50:29+0000",
    comments = "version: 1.5.5.Final, compiler: javac, environment: Java 17.0.16 (Eclipse Adoptium)"
)
@Component
public class CarreraMapperImpl implements CarreraMapper {

    @Override
    public CarreraDTO toDTO(Carrera carrera) {
        if ( carrera == null ) {
            return null;
        }

        CarreraDTO carreraDTO = new CarreraDTO();

        carreraDTO.setFacultadId( carreraFacultadId( carrera ) );
        carreraDTO.setNombreFacultad( carreraFacultadNombreFacultad( carrera ) );
        carreraDTO.setId( carrera.getId() );
        carreraDTO.setNombreCarrera( carrera.getNombreCarrera() );
        carreraDTO.setCreatedAt( carrera.getCreatedAt() );
        carreraDTO.setUpdatedAt( carrera.getUpdatedAt() );

        return carreraDTO;
    }

    @Override
    public List<CarreraDTO> toDTOList(List<Carrera> carreras) {
        if ( carreras == null ) {
            return null;
        }

        List<CarreraDTO> list = new ArrayList<CarreraDTO>( carreras.size() );
        for ( Carrera carrera : carreras ) {
            list.add( toDTO( carrera ) );
        }

        return list;
    }

    @Override
    public Carrera toEntity(CarreraDTO carreraDTO) {
        if ( carreraDTO == null ) {
            return null;
        }

        Carrera carrera = new Carrera();

        carrera.setId( carreraDTO.getId() );
        carrera.setNombreCarrera( carreraDTO.getNombreCarrera() );

        return carrera;
    }

    private Long carreraFacultadId(Carrera carrera) {
        if ( carrera == null ) {
            return null;
        }
        Facultad facultad = carrera.getFacultad();
        if ( facultad == null ) {
            return null;
        }
        Long id = facultad.getId();
        if ( id == null ) {
            return null;
        }
        return id;
    }

    private String carreraFacultadNombreFacultad(Carrera carrera) {
        if ( carrera == null ) {
            return null;
        }
        Facultad facultad = carrera.getFacultad();
        if ( facultad == null ) {
            return null;
        }
        String nombreFacultad = facultad.getNombreFacultad();
        if ( nombreFacultad == null ) {
            return null;
        }
        return nombreFacultad;
    }
}
