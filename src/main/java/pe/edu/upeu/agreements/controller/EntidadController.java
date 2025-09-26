package pe.edu.upeu.agreements.controller;

import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.Parameter;
import io.swagger.v3.oas.annotations.responses.ApiResponse;
import io.swagger.v3.oas.annotations.tags.Tag;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import pe.edu.upeu.agreements.dto.EntidadDTO;
import pe.edu.upeu.agreements.dto.request.EntidadRequestDTO;
import pe.edu.upeu.agreements.service.EntidadService;

import java.util.List;

/**
 * REST Controller for Entidad operations
 * 
 * @author UPeU Development Team
 */
@RestController
@RequestMapping("/api/v1/entidades")
@RequiredArgsConstructor
@Slf4j
@Tag(name = "Entidades", description = "API para gestión de entidades externas")
public class EntidadController {

    private final EntidadService entidadService;

    @Operation(summary = "Obtener todas las entidades", description = "Retorna una lista de todas las entidades")
    @GetMapping
    public ResponseEntity<List<EntidadDTO>> getAllEntidades() {
        log.debug("REST request to get all Entidades");
        List<EntidadDTO> entidades = entidadService.findAll();
        return ResponseEntity.ok(entidades);
    }

    @Operation(summary = "Obtener entidades paginadas", description = "Retorna entidades con paginación")
    @GetMapping("/paginated")
    public ResponseEntity<Page<EntidadDTO>> getAllEntidadesPaginated(
            @Parameter(description = "Número de página") @RequestParam(defaultValue = "0") int page,
            @Parameter(description = "Tamaño de página") @RequestParam(defaultValue = "10") int size,
            @Parameter(description = "Campo de ordenación") @RequestParam(defaultValue = "id") String sortBy,
            @Parameter(description = "Dirección de ordenación") @RequestParam(defaultValue = "asc") String sortDir) {
        
        log.debug("REST request to get paginated Entidades - page: {}, size: {}, sortBy: {}, sortDir: {}", 
                 page, size, sortBy, sortDir);
        
        Sort sort = sortDir.equalsIgnoreCase("desc") ? Sort.by(sortBy).descending() : Sort.by(sortBy).ascending();
        Pageable pageable = PageRequest.of(page, size, sort);
        
        Page<EntidadDTO> entidades = entidadService.findAll(pageable);
        return ResponseEntity.ok(entidades);
    }

    @Operation(summary = "Obtener entidad por ID", description = "Retorna una entidad específica por su ID")
    @GetMapping("/{id}")
    public ResponseEntity<EntidadDTO> getEntidadById(
            @Parameter(description = "ID de la entidad") @PathVariable Long id) {
        log.debug("REST request to get Entidad : {}", id);
        
        return entidadService.findById(id)
                .map(entidad -> ResponseEntity.ok().body(entidad))
                .orElse(ResponseEntity.notFound().build());
    }

    @Operation(summary = "Buscar entidades por nombre", description = "Busca entidades que contengan el nombre especificado")
    @GetMapping("/search")
    public ResponseEntity<List<EntidadDTO>> searchEntidadesByNombre(
            @Parameter(description = "Nombre a buscar") @RequestParam String nombre) {
        log.debug("REST request to search Entidades by nombre : {}", nombre);
        
        List<EntidadDTO> entidades = entidadService.findByNombre(nombre);
        return ResponseEntity.ok(entidades);
    }

    @Operation(summary = "Búsqueda avanzada de entidades", description = "Busca entidades por múltiples criterios")
    @GetMapping("/advanced-search")
    public ResponseEntity<List<EntidadDTO>> advancedSearch(
            @Parameter(description = "Nombre a buscar") @RequestParam(required = false) String nombre,
            @Parameter(description = "Ubicación a buscar") @RequestParam(required = false) String ubicacion,
            @Parameter(description = "Contacto a buscar") @RequestParam(required = false) String contacto) {
        log.debug("REST request for advanced search - nombre: {}, ubicacion: {}, contacto: {}", 
                 nombre, ubicacion, contacto);
        
        List<EntidadDTO> entidades = entidadService.findByMultipleCriteria(nombre, ubicacion, contacto);
        return ResponseEntity.ok(entidades);
    }

    @Operation(summary = "Crear nueva entidad", description = "Crea una nueva entidad")
    @ApiResponse(responseCode = "201", description = "Entidad creada exitosamente")
    @ApiResponse(responseCode = "400", description = "Datos inválidos")
    @PostMapping
    public ResponseEntity<EntidadDTO> createEntidad(
            @Parameter(description = "Datos de la entidad a crear") @Valid @RequestBody EntidadRequestDTO entidadRequestDTO) {
        log.debug("REST request to save Entidad : {}", entidadRequestDTO);
        
        try {
            EntidadDTO createdEntidad = entidadService.create(entidadRequestDTO);
            return ResponseEntity.status(HttpStatus.CREATED).body(createdEntidad);
        } catch (IllegalArgumentException e) {
            log.warn("Error creating entidad: {}", e.getMessage());
            return ResponseEntity.badRequest().build();
        }
    }

    @Operation(summary = "Actualizar entidad", description = "Actualiza una entidad existente")
    @ApiResponse(responseCode = "200", description = "Entidad actualizada exitosamente")
    @ApiResponse(responseCode = "404", description = "Entidad no encontrada")
    @ApiResponse(responseCode = "400", description = "Datos inválidos")
    @PutMapping("/{id}")
    public ResponseEntity<EntidadDTO> updateEntidad(
            @Parameter(description = "ID de la entidad") @PathVariable Long id,
            @Parameter(description = "Datos actualizados de la entidad") @Valid @RequestBody EntidadRequestDTO entidadRequestDTO) {
        log.debug("REST request to update Entidad : {} with data: {}", id, entidadRequestDTO);
        
        try {
            EntidadDTO updatedEntidad = entidadService.update(id, entidadRequestDTO);
            return ResponseEntity.ok(updatedEntidad);
        } catch (IllegalArgumentException e) {
            log.warn("Error updating entidad: {}", e.getMessage());
            return ResponseEntity.badRequest().build();
        }
    }

    @Operation(summary = "Eliminar entidad", description = "Elimina una entidad por su ID")
    @ApiResponse(responseCode = "204", description = "Entidad eliminada exitosamente")
    @ApiResponse(responseCode = "404", description = "Entidad no encontrada")
    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteEntidad(
            @Parameter(description = "ID de la entidad") @PathVariable Long id) {
        log.debug("REST request to delete Entidad : {}", id);
        
        try {
            entidadService.delete(id);
            return ResponseEntity.noContent().build();
        } catch (IllegalArgumentException e) {
            log.warn("Error deleting entidad: {}", e.getMessage());
            return ResponseEntity.notFound().build();
        }
    }

    @Operation(summary = "Verificar si existe entidad", description = "Verifica si existe una entidad con el ID especificado")
    @GetMapping("/{id}/exists")
    public ResponseEntity<Boolean> existsEntidad(
            @Parameter(description = "ID de la entidad") @PathVariable Long id) {
        log.debug("REST request to check if Entidad exists : {}", id);
        
        boolean exists = entidadService.existsById(id);
        return ResponseEntity.ok(exists);
    }
}