package pe.edu.upeu.agreements.dto.request;

import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import pe.edu.upeu.agreements.entity.enums.AlcanceConvenio;
import pe.edu.upeu.agreements.entity.enums.AmbitoConvenio;

import java.time.LocalDate;

/**
 * Request DTO for creating/updating Convenio
 * 
 * @author UPeU Development Team
 */
@Data
@NoArgsConstructor
@AllArgsConstructor
public class ConvenioRequestDTO {
    
    @NotBlank(message = "El nombre del convenio es obligatorio")
    private String nombreConvenio;
    
    private String descripcion;
    
    @NotNull(message = "La fecha de inicio es obligatoria")
    private LocalDate fechaInicio;
    
    private LocalDate fechaFin;
    
    @NotNull(message = "El alcance es obligatorio")
    private AlcanceConvenio alcance;
    
    @NotNull(message = "El ID de la entidad es obligatorio")
    private Long entidadId;
    
    private Long facultadId;
    
    private Long carreraId;
    
    private AmbitoConvenio ambito1;
    private AmbitoConvenio ambito2;
    private AmbitoConvenio ambito3;
}