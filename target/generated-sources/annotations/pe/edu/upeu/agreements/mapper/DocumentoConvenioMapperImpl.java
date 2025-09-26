package pe.edu.upeu.agreements.mapper;

import java.util.ArrayList;
import java.util.List;
import javax.annotation.processing.Generated;
import org.springframework.stereotype.Component;
import pe.edu.upeu.agreements.dto.DocumentoConvenioDTO;
import pe.edu.upeu.agreements.entity.Convenio;
import pe.edu.upeu.agreements.entity.DocumentoConvenio;

@Generated(
    value = "org.mapstruct.ap.MappingProcessor",
    date = "2025-09-26T20:50:29+0000",
    comments = "version: 1.5.5.Final, compiler: javac, environment: Java 17.0.16 (Eclipse Adoptium)"
)
@Component
public class DocumentoConvenioMapperImpl implements DocumentoConvenioMapper {

    @Override
    public DocumentoConvenioDTO toDTO(DocumentoConvenio documentoConvenio) {
        if ( documentoConvenio == null ) {
            return null;
        }

        DocumentoConvenioDTO documentoConvenioDTO = new DocumentoConvenioDTO();

        documentoConvenioDTO.setConvenioId( documentoConvenioConvenioId( documentoConvenio ) );
        documentoConvenioDTO.setNombreConvenio( documentoConvenioConvenioNombreConvenio( documentoConvenio ) );
        documentoConvenioDTO.setId( documentoConvenio.getId() );
        documentoConvenioDTO.setNombreArchivo( documentoConvenio.getNombreArchivo() );
        documentoConvenioDTO.setTipoDocumento( documentoConvenio.getTipoDocumento() );
        documentoConvenioDTO.setFechaSubida( documentoConvenio.getFechaSubida() );
        documentoConvenioDTO.setHoraSubida( documentoConvenio.getHoraSubida() );
        documentoConvenioDTO.setRuta( documentoConvenio.getRuta() );
        documentoConvenioDTO.setCreatedAt( documentoConvenio.getCreatedAt() );
        documentoConvenioDTO.setUpdatedAt( documentoConvenio.getUpdatedAt() );

        return documentoConvenioDTO;
    }

    @Override
    public List<DocumentoConvenioDTO> toDTOList(List<DocumentoConvenio> documentos) {
        if ( documentos == null ) {
            return null;
        }

        List<DocumentoConvenioDTO> list = new ArrayList<DocumentoConvenioDTO>( documentos.size() );
        for ( DocumentoConvenio documentoConvenio : documentos ) {
            list.add( toDTO( documentoConvenio ) );
        }

        return list;
    }

    @Override
    public DocumentoConvenio toEntity(DocumentoConvenioDTO documentoConvenioDTO) {
        if ( documentoConvenioDTO == null ) {
            return null;
        }

        DocumentoConvenio documentoConvenio = new DocumentoConvenio();

        documentoConvenio.setId( documentoConvenioDTO.getId() );
        documentoConvenio.setNombreArchivo( documentoConvenioDTO.getNombreArchivo() );
        documentoConvenio.setTipoDocumento( documentoConvenioDTO.getTipoDocumento() );
        documentoConvenio.setFechaSubida( documentoConvenioDTO.getFechaSubida() );
        documentoConvenio.setHoraSubida( documentoConvenioDTO.getHoraSubida() );
        documentoConvenio.setRuta( documentoConvenioDTO.getRuta() );

        return documentoConvenio;
    }

    private Long documentoConvenioConvenioId(DocumentoConvenio documentoConvenio) {
        if ( documentoConvenio == null ) {
            return null;
        }
        Convenio convenio = documentoConvenio.getConvenio();
        if ( convenio == null ) {
            return null;
        }
        Long id = convenio.getId();
        if ( id == null ) {
            return null;
        }
        return id;
    }

    private String documentoConvenioConvenioNombreConvenio(DocumentoConvenio documentoConvenio) {
        if ( documentoConvenio == null ) {
            return null;
        }
        Convenio convenio = documentoConvenio.getConvenio();
        if ( convenio == null ) {
            return null;
        }
        String nombreConvenio = convenio.getNombreConvenio();
        if ( nombreConvenio == null ) {
            return null;
        }
        return nombreConvenio;
    }
}
