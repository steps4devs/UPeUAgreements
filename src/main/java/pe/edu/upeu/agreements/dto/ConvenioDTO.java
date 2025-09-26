package pe.edu.upeu.agreements.dto;

import com.fasterxml.jackson.annotation.JsonInclude;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import pe.edu.upeu.agreements.entity.enums.AlcanceConvenio;
import pe.edu.upeu.agreements.entity.enums.AmbitoConvenio;
import pe.edu.upeu.agreements.entity.enums.EstadoConvenio;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.List;

/**
 * DTO for Convenio entity
 * 
 * @author UPeU Development Team
 */
@Data
@NoArgsConstructor
@AllArgsConstructor
@JsonInclude(JsonInclude.Include.NON_NULL)
public class ConvenioDTO {
    
    private Long id;
    
    @NotBlank(message = "El nombre del convenio es obligatorio")
    private String nombreConvenio;
    
    private String descripcion;
    
    @NotNull(message = "La fecha de inicio es obligatoria")
    private LocalDate fechaInicio;
    
    private LocalDate fechaFin;
    
    @NotNull(message = "El estado es obligatorio")
    private EstadoConvenio estado;
    
    @NotNull(message = "El alcance es obligatorio")
    private AlcanceConvenio alcance;
    
    @NotNull(message = "El ID del creador es obligatorio")
    private Long convenioCreadorId;
    private String nombreCreador; // For display
    
    @NotNull(message = "El ID de la entidad es obligatorio")
    private Long entidadId;
    private String nombreEntidad; // For display
    
    private Long facultadId;
    private String nombreFacultad; // For display
    
    private Long carreraId;
    private String nombreCarrera; // For display
    
    private AmbitoConvenio ambito1;
    private AmbitoConvenio ambito2;
    private AmbitoConvenio ambito3;
    
    private LocalDateTime createdAt;
    private LocalDateTime updatedAt;
    
    // Documents list for detailed view
    private List<DocumentoConvenioDTO> documentos;
}