package pe.edu.upeu.agreements.mapper;

import java.util.ArrayList;
import java.util.List;
import javax.annotation.processing.Generated;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;
import pe.edu.upeu.agreements.dto.ConvenioDTO;
import pe.edu.upeu.agreements.dto.request.ConvenioRequestDTO;
import pe.edu.upeu.agreements.entity.Carrera;
import pe.edu.upeu.agreements.entity.Convenio;
import pe.edu.upeu.agreements.entity.Entidad;
import pe.edu.upeu.agreements.entity.Facultad;
import pe.edu.upeu.agreements.entity.User;

@Generated(
    value = "org.mapstruct.ap.MappingProcessor",
    date = "2025-09-26T20:50:29+0000",
    comments = "version: 1.5.5.Final, compiler: javac, environment: Java 17.0.16 (Eclipse Adoptium)"
)
@Component
public class ConvenioMapperImpl implements ConvenioMapper {

    @Autowired
    private DocumentoConvenioMapper documentoConvenioMapper;

    @Override
    public ConvenioDTO toDTO(Convenio convenio) {
        if ( convenio == null ) {
            return null;
        }

        ConvenioDTO convenioDTO = new ConvenioDTO();

        convenioDTO.setConvenioCreadorId( convenioConvenioCreadorId( convenio ) );
        convenioDTO.setNombreCreador( convenioConvenioCreadorName( convenio ) );
        convenioDTO.setEntidadId( convenioEntidadId( convenio ) );
        convenioDTO.setNombreEntidad( convenioEntidadNombreEntidad( convenio ) );
        convenioDTO.setFacultadId( convenioFacultadId( convenio ) );
        convenioDTO.setNombreFacultad( convenioFacultadNombreFacultad( convenio ) );
        convenioDTO.setCarreraId( convenioCarreraId( convenio ) );
        convenioDTO.setNombreCarrera( convenioCarreraNombreCarrera( convenio ) );
        convenioDTO.setId( convenio.getId() );
        convenioDTO.setNombreConvenio( convenio.getNombreConvenio() );
        convenioDTO.setDescripcion( convenio.getDescripcion() );
        convenioDTO.setFechaInicio( convenio.getFechaInicio() );
        convenioDTO.setFechaFin( convenio.getFechaFin() );
        convenioDTO.setEstado( convenio.getEstado() );
        convenioDTO.setAlcance( convenio.getAlcance() );
        convenioDTO.setAmbito1( convenio.getAmbito1() );
        convenioDTO.setAmbito2( convenio.getAmbito2() );
        convenioDTO.setAmbito3( convenio.getAmbito3() );
        convenioDTO.setCreatedAt( convenio.getCreatedAt() );
        convenioDTO.setUpdatedAt( convenio.getUpdatedAt() );
        convenioDTO.setDocumentos( documentoConvenioMapper.toDTOList( convenio.getDocumentos() ) );

        return convenioDTO;
    }

    @Override
    public List<ConvenioDTO> toDTOList(List<Convenio> convenios) {
        if ( convenios == null ) {
            return null;
        }

        List<ConvenioDTO> list = new ArrayList<ConvenioDTO>( convenios.size() );
        for ( Convenio convenio : convenios ) {
            list.add( toDTO( convenio ) );
        }

        return list;
    }

    @Override
    public Convenio toEntity(ConvenioRequestDTO convenioRequestDTO) {
        if ( convenioRequestDTO == null ) {
            return null;
        }

        Convenio convenio = new Convenio();

        convenio.setNombreConvenio( convenioRequestDTO.getNombreConvenio() );
        convenio.setDescripcion( convenioRequestDTO.getDescripcion() );
        convenio.setFechaInicio( convenioRequestDTO.getFechaInicio() );
        convenio.setFechaFin( convenioRequestDTO.getFechaFin() );
        convenio.setAlcance( convenioRequestDTO.getAlcance() );
        convenio.setAmbito1( convenioRequestDTO.getAmbito1() );
        convenio.setAmbito2( convenioRequestDTO.getAmbito2() );
        convenio.setAmbito3( convenioRequestDTO.getAmbito3() );

        return convenio;
    }

    @Override
    public void updateEntity(ConvenioRequestDTO convenioRequestDTO, Convenio convenio) {
        if ( convenioRequestDTO == null ) {
            return;
        }

        convenio.setNombreConvenio( convenioRequestDTO.getNombreConvenio() );
        convenio.setDescripcion( convenioRequestDTO.getDescripcion() );
        convenio.setFechaInicio( convenioRequestDTO.getFechaInicio() );
        convenio.setFechaFin( convenioRequestDTO.getFechaFin() );
        convenio.setAlcance( convenioRequestDTO.getAlcance() );
        convenio.setAmbito1( convenioRequestDTO.getAmbito1() );
        convenio.setAmbito2( convenioRequestDTO.getAmbito2() );
        convenio.setAmbito3( convenioRequestDTO.getAmbito3() );
    }

    private Long convenioConvenioCreadorId(Convenio convenio) {
        if ( convenio == null ) {
            return null;
        }
        User convenioCreador = convenio.getConvenioCreador();
        if ( convenioCreador == null ) {
            return null;
        }
        Long id = convenioCreador.getId();
        if ( id == null ) {
            return null;
        }
        return id;
    }

    private String convenioConvenioCreadorName(Convenio convenio) {
        if ( convenio == null ) {
            return null;
        }
        User convenioCreador = convenio.getConvenioCreador();
        if ( convenioCreador == null ) {
            return null;
        }
        String name = convenioCreador.getName();
        if ( name == null ) {
            return null;
        }
        return name;
    }

    private Long convenioEntidadId(Convenio convenio) {
        if ( convenio == null ) {
            return null;
        }
        Entidad entidad = convenio.getEntidad();
        if ( entidad == null ) {
            return null;
        }
        Long id = entidad.getId();
        if ( id == null ) {
            return null;
        }
        return id;
    }

    private String convenioEntidadNombreEntidad(Convenio convenio) {
        if ( convenio == null ) {
            return null;
        }
        Entidad entidad = convenio.getEntidad();
        if ( entidad == null ) {
            return null;
        }
        String nombreEntidad = entidad.getNombreEntidad();
        if ( nombreEntidad == null ) {
            return null;
        }
        return nombreEntidad;
    }

    private Long convenioFacultadId(Convenio convenio) {
        if ( convenio == null ) {
            return null;
        }
        Facultad facultad = convenio.getFacultad();
        if ( facultad == null ) {
            return null;
        }
        Long id = facultad.getId();
        if ( id == null ) {
            return null;
        }
        return id;
    }

    private String convenioFacultadNombreFacultad(Convenio convenio) {
        if ( convenio == null ) {
            return null;
        }
        Facultad facultad = convenio.getFacultad();
        if ( facultad == null ) {
            return null;
        }
        String nombreFacultad = facultad.getNombreFacultad();
        if ( nombreFacultad == null ) {
            return null;
        }
        return nombreFacultad;
    }

    private Long convenioCarreraId(Convenio convenio) {
        if ( convenio == null ) {
            return null;
        }
        Carrera carrera = convenio.getCarrera();
        if ( carrera == null ) {
            return null;
        }
        Long id = carrera.getId();
        if ( id == null ) {
            return null;
        }
        return id;
    }

    private String convenioCarreraNombreCarrera(Convenio convenio) {
        if ( convenio == null ) {
            return null;
        }
        Carrera carrera = convenio.getCarrera();
        if ( carrera == null ) {
            return null;
        }
        String nombreCarrera = carrera.getNombreCarrera();
        if ( nombreCarrera == null ) {
            return null;
        }
        return nombreCarrera;
    }
}
