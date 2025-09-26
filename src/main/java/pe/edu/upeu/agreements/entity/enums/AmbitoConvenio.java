package pe.edu.upeu.agreements.entity.enums;

/**
 * Ambito enum for Convenio entity
 */
public enum AmbitoConvenio {
    INVESTIGACION("Investigación"),
    PRACTICAS_PROFESIONALES("Prácticas Profesionales"),
    TRANSFERENCIA_TECNOLOGICA("Transferencia Tecnológica"),
    MOVILIDAD_ACADEMICA("Movilidad Académica"),
    CAPACITACION("Capacitación"),
    DESARROLLO_PROYECTOS("Desarrollo de Proyectos"),
    INTERCAMBIO_CULTURAL("Intercambio Cultural"),
    RESPONSABILIDAD_SOCIAL("Responsabilidad Social"),
    INNOVACION("Innovación"),
    EMPRENDIMIENTO("Emprendimiento"),
    SERVICIOS_TECNOLOGICOS("Servicios Tecnológicos"),
    CONSULTORIA("Consultoría"),
    EDUCACION_CONTINUA("Educación Continua"),
    DESARROLLO_SOSTENIBLE("Desarrollo Sostenible"),
    VINCULACION_EMPRESARIAL("Vinculación Empresarial"),
    INTERNACIONALIZACION("Internacionalización"),
    PUBLICACIONES("Publicaciones"),
    EVENTOS_ACADEMICOS("Eventos Académicos"),
    OTROS("Otros");

    private final String displayName;

    AmbitoConvenio(String displayName) {
        this.displayName = displayName;
    }

    public String getDisplayName() {
        return displayName;
    }
}