package pe.edu.upeu.agreements.dto.request;

import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.Size;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

/**
 * Request DTO for creating/updating Entidad
 * 
 * @author UPeU Development Team
 */
@Data
@NoArgsConstructor
@AllArgsConstructor
public class EntidadRequestDTO {
    
    @NotBlank(message = "El nombre de la entidad es obligatorio")
    @Size(max = 200, message = "El nombre no puede exceder los 200 caracteres")
    private String nombreEntidad;
    
    private String logo;
    
    @NotBlank(message = "La ubicación es obligatoria")
    @Size(max = 200, message = "La ubicación no puede exceder los 200 caracteres")
    private String ubicacion;
    
    @NotBlank(message = "El contacto es obligatorio")
    @Size(max = 100, message = "El contacto no puede exceder los 100 caracteres")
    private String contacto;
}