package pe.edu.upeu.agreements.mapper;

import java.util.ArrayList;
import java.util.List;
import javax.annotation.processing.Generated;
import org.springframework.stereotype.Component;
import pe.edu.upeu.agreements.dto.EntidadDTO;
import pe.edu.upeu.agreements.dto.request.EntidadRequestDTO;
import pe.edu.upeu.agreements.entity.Entidad;

@Generated(
    value = "org.mapstruct.ap.MappingProcessor",
    date = "2025-09-26T20:50:29+0000",
    comments = "version: 1.5.5.Final, compiler: javac, environment: Java 17.0.16 (Eclipse Adoptium)"
)
@Component
public class EntidadMapperImpl implements EntidadMapper {

    @Override
    public EntidadDTO toDTO(Entidad entidad) {
        if ( entidad == null ) {
            return null;
        }

        EntidadDTO entidadDTO = new EntidadDTO();

        entidadDTO.setId( entidad.getId() );
        entidadDTO.setNombreEntidad( entidad.getNombreEntidad() );
        entidadDTO.setLogo( entidad.getLogo() );
        entidadDTO.setUbicacion( entidad.getUbicacion() );
        entidadDTO.setContacto( entidad.getContacto() );
        entidadDTO.setCreatedAt( entidad.getCreatedAt() );
        entidadDTO.setUpdatedAt( entidad.getUpdatedAt() );

        return entidadDTO;
    }

    @Override
    public List<EntidadDTO> toDTOList(List<Entidad> entidades) {
        if ( entidades == null ) {
            return null;
        }

        List<EntidadDTO> list = new ArrayList<EntidadDTO>( entidades.size() );
        for ( Entidad entidad : entidades ) {
            list.add( toDTO( entidad ) );
        }

        return list;
    }

    @Override
    public Entidad toEntity(EntidadRequestDTO entidadRequestDTO) {
        if ( entidadRequestDTO == null ) {
            return null;
        }

        Entidad entidad = new Entidad();

        entidad.setNombreEntidad( entidadRequestDTO.getNombreEntidad() );
        entidad.setLogo( entidadRequestDTO.getLogo() );
        entidad.setUbicacion( entidadRequestDTO.getUbicacion() );
        entidad.setContacto( entidadRequestDTO.getContacto() );

        return entidad;
    }

    @Override
    public void updateEntity(EntidadRequestDTO entidadRequestDTO, Entidad entidad) {
        if ( entidadRequestDTO == null ) {
            return;
        }

        entidad.setNombreEntidad( entidadRequestDTO.getNombreEntidad() );
        entidad.setLogo( entidadRequestDTO.getLogo() );
        entidad.setUbicacion( entidadRequestDTO.getUbicacion() );
        entidad.setContacto( entidadRequestDTO.getContacto() );
    }
}
