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
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.web.bind.annotation.*;
import pe.edu.upeu.agreements.dto.ConvenioDTO;
import pe.edu.upeu.agreements.dto.request.ConvenioRequestDTO;
import pe.edu.upeu.agreements.entity.User;
import pe.edu.upeu.agreements.service.ConvenioService;

import java.util.List;

/**
 * REST Controller for Convenio operations
 * 
 * @author UPeU Development Team
 */
@RestController
@RequestMapping("/api/v1/convenios")
@RequiredArgsConstructor
@Slf4j
@Tag(name = "Convenios", description = "API para gestión de convenios/acuerdos")
public class ConvenioController {

    private final ConvenioService convenioService;

    @Operation(summary = "Obtener todos los convenios", description = "Retorna una lista de todos los convenios")
    @GetMapping
    public ResponseEntity<List<ConvenioDTO>> getAllConvenios() {
        log.debug("REST request to get all Convenios");
        List<ConvenioDTO> convenios = convenioService.findAll();
        return ResponseEntity.ok(convenios);
    }

    @Operation(summary = "Obtener convenios paginados", description = "Retorna convenios con paginación")
    @GetMapping("/paginated")
    public ResponseEntity<Page<ConvenioDTO>> getAllConveniosPaginated(
            @Parameter(description = "Número de página") @RequestParam(defaultValue = "0") int page,
            @Parameter(description = "Tamaño de página") @RequestParam(defaultValue = "10") int size,
            @Parameter(description = "Campo de ordenación") @RequestParam(defaultValue = "id") String sortBy,
            @Parameter(description = "Dirección de ordenación") @RequestParam(defaultValue = "asc") String sortDir) {
        
        log.debug("REST request to get paginated Convenios - page: {}, size: {}, sortBy: {}, sortDir: {}", 
                 page, size, sortBy, sortDir);
        
        Sort sort = sortDir.equalsIgnoreCase("desc") ? Sort.by(sortBy).descending() : Sort.by(sortBy).ascending();
        Pageable pageable = PageRequest.of(page, size, sort);
        
        Page<ConvenioDTO> convenios = convenioService.findAll(pageable);
        return ResponseEntity.ok(convenios);
    }

    @Operation(summary = "Obtener convenio por ID", description = "Retorna un convenio específico por su ID")
    @GetMapping("/{id}")
    public ResponseEntity<ConvenioDTO> getConvenioById(
            @Parameter(description = "ID del convenio") @PathVariable Long id) {
        log.debug("REST request to get Convenio : {}", id);
        
        return convenioService.findById(id)
                .map(convenio -> ResponseEntity.ok().body(convenio))
                .orElse(ResponseEntity.notFound().build());
    }

    @Operation(summary = "Buscar convenios por nombre", description = "Busca convenios que contengan el nombre especificado")
    @GetMapping("/search")
    public ResponseEntity<List<ConvenioDTO>> searchConveniosByNombre(
            @Parameter(description = "Nombre a buscar") @RequestParam String nombre) {
        log.debug("REST request to search Convenios by nombre : {}", nombre);
        
        List<ConvenioDTO> convenios = convenioService.findByNombre(nombre);
        return ResponseEntity.ok(convenios);
    }

    @Operation(summary = "Obtener convenios que vencen pronto", description = "Retorna convenios que vencen en los próximos 30 días")
    @GetMapping("/expiring-soon")
    public ResponseEntity<List<ConvenioDTO>> getExpiringSoonConvenios() {
        log.debug("REST request to get expiring soon Convenios");
        
        List<ConvenioDTO> convenios = convenioService.findExpiringSoon();
        return ResponseEntity.ok(convenios);
    }

    @Operation(summary = "Crear nuevo convenio", description = "Crea un nuevo convenio")
    @ApiResponse(responseCode = "201", description = "Convenio creado exitosamente")
    @ApiResponse(responseCode = "400", description = "Datos inválidos")
    @PostMapping
    public ResponseEntity<ConvenioDTO> createConvenio(
            @Parameter(description = "Datos del convenio a crear") @Valid @RequestBody ConvenioRequestDTO convenioRequestDTO) {
        log.debug("REST request to save Convenio : {}", convenioRequestDTO);
        
        try {
            // Get current user ID from security context
            Long currentUserId = getCurrentUserId();
            
            ConvenioDTO createdConvenio = convenioService.create(convenioRequestDTO, currentUserId);
            return ResponseEntity.status(HttpStatus.CREATED).body(createdConvenio);
        } catch (IllegalArgumentException e) {
            log.warn("Error creating convenio: {}", e.getMessage());
            return ResponseEntity.badRequest().build();
        }
    }

    @Operation(summary = "Actualizar convenio", description = "Actualiza un convenio existente")
    @ApiResponse(responseCode = "200", description = "Convenio actualizado exitosamente")
    @ApiResponse(responseCode = "404", description = "Convenio no encontrado")
    @ApiResponse(responseCode = "400", description = "Datos inválidos")
    @PutMapping("/{id}")
    public ResponseEntity<ConvenioDTO> updateConvenio(
            @Parameter(description = "ID del convenio") @PathVariable Long id,
            @Parameter(description = "Datos actualizados del convenio") @Valid @RequestBody ConvenioRequestDTO convenioRequestDTO) {
        log.debug("REST request to update Convenio : {} with data: {}", id, convenioRequestDTO);
        
        try {
            ConvenioDTO updatedConvenio = convenioService.update(id, convenioRequestDTO);
            return ResponseEntity.ok(updatedConvenio);
        } catch (IllegalArgumentException e) {
            log.warn("Error updating convenio: {}", e.getMessage());
            return ResponseEntity.badRequest().build();
        }
    }

    @Operation(summary = "Eliminar convenio", description = "Elimina un convenio por su ID")
    @ApiResponse(responseCode = "204", description = "Convenio eliminado exitosamente")
    @ApiResponse(responseCode = "404", description = "Convenio no encontrado")
    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteConvenio(
            @Parameter(description = "ID del convenio") @PathVariable Long id) {
        log.debug("REST request to delete Convenio : {}", id);
        
        try {
            convenioService.delete(id);
            return ResponseEntity.noContent().build();
        } catch (IllegalArgumentException e) {
            log.warn("Error deleting convenio: {}", e.getMessage());
            return ResponseEntity.notFound().build();
        }
    }

    @Operation(summary = "Actualizar estados de todos los convenios", description = "Actualiza el estado de todos los convenios basado en fechas")
    @ApiResponse(responseCode = "200", description = "Estados actualizados exitosamente")
    @PatchMapping("/update-statuses")
    public ResponseEntity<Void> updateAllStatuses() {
        log.debug("REST request to update all Convenio statuses");
        
        convenioService.updateAllStatuses();
        return ResponseEntity.ok().build();
    }

    @Operation(summary = "Verificar si existe convenio", description = "Verifica si existe un convenio con el ID especificado")
    @GetMapping("/{id}/exists")
    public ResponseEntity<Boolean> existsConvenio(
            @Parameter(description = "ID del convenio") @PathVariable Long id) {
        log.debug("REST request to check if Convenio exists : {}", id);
        
        boolean exists = convenioService.existsById(id);
        return ResponseEntity.ok(exists);
    }

    /**
     * Get current user ID from security context
     */
    private Long getCurrentUserId() {
        Authentication authentication = SecurityContextHolder.getContext().getAuthentication();
        if (authentication != null && authentication.getPrincipal() instanceof User user) {
            return user.getId();
        }
        // For development/testing purposes, return a default user ID
        // In production, this should throw an exception
        log.warn("No authenticated user found, using default user ID 1");
        return 1L;
    }
}