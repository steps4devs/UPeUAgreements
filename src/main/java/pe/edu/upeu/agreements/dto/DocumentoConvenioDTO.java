package pe.edu.upeu.agreements.dto;

import com.fasterxml.jackson.annotation.JsonInclude;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import pe.edu.upeu.agreements.entity.enums.TipoDocumento;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.time.LocalTime;

/**
 * DTO for DocumentoConvenio entity
 * 
 * @author UPeU Development Team
 */
@Data
@NoArgsConstructor
@AllArgsConstructor
@JsonInclude(JsonInclude.Include.NON_NULL)
public class DocumentoConvenioDTO {
    
    private Long id;
    
    @NotBlank(message = "El nombre del archivo es obligatorio")
    private String nombreArchivo;
    
    @NotNull(message = "El tipo de documento es obligatorio")
    private TipoDocumento tipoDocumento;
    
    @NotNull(message = "La fecha de subida es obligatoria")
    private LocalDate fechaSubida;
    
    @NotNull(message = "La hora de subida es obligatoria")
    private LocalTime horaSubida;
    
    private String ruta;
    
    @NotNull(message = "El ID del convenio es obligatorio")
    private Long convenioId;
    private String nombreConvenio; // For display
    
    private LocalDateTime createdAt;
    private LocalDateTime updatedAt;
}