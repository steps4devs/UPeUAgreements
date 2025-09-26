package pe.edu.upeu.agreements.entity;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;
import pe.edu.upeu.agreements.entity.enums.AlcanceConvenio;
import pe.edu.upeu.agreements.entity.enums.AmbitoConvenio;
import pe.edu.upeu.agreements.entity.enums.EstadoConvenio;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.List;

/**
 * Convenio entity representing agreements between university and external entities
 * 
 * @author UPeU Development Team
 */
@Entity
@Table(name = "convenios")
@Data
@NoArgsConstructor
@AllArgsConstructor
@EntityListeners(AuditingEntityListener.class)
public class Convenio {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(name = "nombreConvenio", nullable = false)
    private String nombreConvenio;

    @Column(name = "descripcion")
    private String descripcion;

    @Column(name = "fecha_inicio", nullable = false)
    private LocalDate fechaInicio;

    @Column(name = "fecha_fin")
    private LocalDate fechaFin;

    @Enumerated(EnumType.STRING)
    @Column(name = "estado", nullable = false)
    private EstadoConvenio estado;

    @Enumerated(EnumType.STRING)
    @Column(name = "alcance", nullable = false)
    private AlcanceConvenio alcance;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "convenio_creador", nullable = false)
    private User convenioCreador;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "convenio_id_entidad", nullable = false)
    private Entidad entidad;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "facultad_id")
    private Facultad facultad;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "carrera_id")
    private Carrera carrera;

    @Enumerated(EnumType.STRING)
    @Column(name = "ambito_1")
    private AmbitoConvenio ambito1;

    @Enumerated(EnumType.STRING)
    @Column(name = "ambito_2")
    private AmbitoConvenio ambito2;

    @Enumerated(EnumType.STRING)
    @Column(name = "ambito_3")
    private AmbitoConvenio ambito3;

    @CreatedDate
    @Column(name = "created_at", nullable = false, updatable = false)
    private LocalDateTime createdAt;

    @LastModifiedDate
    @Column(name = "updated_at")
    private LocalDateTime updatedAt;

    // Relationships
    @OneToMany(mappedBy = "convenio", cascade = CascadeType.ALL, fetch = FetchType.LAZY)
    private List<DocumentoConvenio> documentos;
}