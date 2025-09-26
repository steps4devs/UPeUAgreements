package pe.edu.upeu.agreements.dto;

import com.fasterxml.jackson.annotation.JsonInclude;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

/**
 * DTO for Carrera entity
 * 
 * @author UPeU Development Team
 */
@Data
@NoArgsConstructor
@AllArgsConstructor
@JsonInclude(JsonInclude.Include.NON_NULL)
public class CarreraDTO {
    
    private Long id;
    
    @NotBlank(message = "El nombre de la carrera es obligatorio")
    private String nombreCarrera;
    
    @NotNull(message = "El ID de la facultad es obligatorio")
    private Long facultadId;
    
    private String nombreFacultad; // For display purposes
    
    private LocalDateTime createdAt;
    private LocalDateTime updatedAt;
}