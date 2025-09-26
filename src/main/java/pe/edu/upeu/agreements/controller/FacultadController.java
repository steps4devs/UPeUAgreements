package pe.edu.upeu.agreements.controller;

import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.Parameter;
import io.swagger.v3.oas.annotations.responses.ApiResponse;
import io.swagger.v3.oas.annotations.tags.Tag;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import pe.edu.upeu.agreements.dto.FacultadDTO;
import pe.edu.upeu.agreements.service.FacultadService;

import java.util.List;

/**
 * REST Controller for Facultad operations
 * 
 * @author UPeU Development Team
 */
@RestController
@RequestMapping("/api/v1/facultades")
@RequiredArgsConstructor
@Slf4j
@Tag(name = "Facultades", description = "API para gestión de facultades universitarias")
public class FacultadController {

    private final FacultadService facultadService;

    @Operation(summary = "Obtener todas las facultades", description = "Retorna una lista de todas las facultades")
    @GetMapping
    public ResponseEntity<List<FacultadDTO>> getAllFacultades() {
        log.debug("REST request to get all Facultades");
        List<FacultadDTO> facultades = facultadService.findAll();
        return ResponseEntity.ok(facultades);
    }

    @Operation(summary = "Obtener facultad por ID", description = "Retorna una facultad específica por su ID")
    @GetMapping("/{id}")
    public ResponseEntity<FacultadDTO> getFacultadById(
            @Parameter(description = "ID de la facultad") @PathVariable Long id) {
        log.debug("REST request to get Facultad : {}", id);
        
        return facultadService.findById(id)
                .map(facultad -> ResponseEntity.ok().body(facultad))
                .orElse(ResponseEntity.notFound().build());
    }

    @Operation(summary = "Buscar facultades por nombre", description = "Busca facultades que contengan el nombre especificado")
    @GetMapping("/search")
    public ResponseEntity<List<FacultadDTO>> searchFacultadesByNombre(
            @Parameter(description = "Nombre a buscar") @RequestParam String nombre) {
        log.debug("REST request to search Facultades by nombre : {}", nombre);
        
        List<FacultadDTO> facultades = facultadService.findByNombre(nombre);
        return ResponseEntity.ok(facultades);
    }

    @Operation(summary = "Crear nueva facultad", description = "Crea una nueva facultad")
    @ApiResponse(responseCode = "201", description = "Facultad creada exitosamente")
    @ApiResponse(responseCode = "400", description = "Datos inválidos")
    @PostMapping
    public ResponseEntity<FacultadDTO> createFacultad(
            @Parameter(description = "Datos de la facultad a crear") @Valid @RequestBody FacultadDTO facultadDTO) {
        log.debug("REST request to save Facultad : {}", facultadDTO);
        
        try {
            FacultadDTO createdFacultad = facultadService.create(facultadDTO);
            return ResponseEntity.status(HttpStatus.CREATED).body(createdFacultad);
        } catch (IllegalArgumentException e) {
            log.warn("Error creating facultad: {}", e.getMessage());
            return ResponseEntity.badRequest().build();
        }
    }

    @Operation(summary = "Actualizar facultad", description = "Actualiza una facultad existente")
    @ApiResponse(responseCode = "200", description = "Facultad actualizada exitosamente")
    @ApiResponse(responseCode = "404", description = "Facultad no encontrada")
    @ApiResponse(responseCode = "400", description = "Datos inválidos")
    @PutMapping("/{id}")
    public ResponseEntity<FacultadDTO> updateFacultad(
            @Parameter(description = "ID de la facultad") @PathVariable Long id,
            @Parameter(description = "Datos actualizados de la facultad") @Valid @RequestBody FacultadDTO facultadDTO) {
        log.debug("REST request to update Facultad : {} with data: {}", id, facultadDTO);
        
        try {
            FacultadDTO updatedFacultad = facultadService.update(id, facultadDTO);
            return ResponseEntity.ok(updatedFacultad);
        } catch (IllegalArgumentException e) {
            log.warn("Error updating facultad: {}", e.getMessage());
            return ResponseEntity.badRequest().build();
        }
    }

    @Operation(summary = "Eliminar facultad", description = "Elimina una facultad por su ID")
    @ApiResponse(responseCode = "204", description = "Facultad eliminada exitosamente")
    @ApiResponse(responseCode = "404", description = "Facultad no encontrada")
    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteFacultad(
            @Parameter(description = "ID de la facultad") @PathVariable Long id) {
        log.debug("REST request to delete Facultad : {}", id);
        
        try {
            facultadService.delete(id);
            return ResponseEntity.noContent().build();
        } catch (IllegalArgumentException e) {
            log.warn("Error deleting facultad: {}", e.getMessage());
            return ResponseEntity.notFound().build();
        }
    }

    @Operation(summary = "Verificar si existe facultad", description = "Verifica si existe una facultad con el ID especificado")
    @GetMapping("/{id}/exists")
    public ResponseEntity<Boolean> existsFacultad(
            @Parameter(description = "ID de la facultad") @PathVariable Long id) {
        log.debug("REST request to check if Facultad exists : {}", id);
        
        boolean exists = facultadService.existsById(id);
        return ResponseEntity.ok(exists);
    }
}