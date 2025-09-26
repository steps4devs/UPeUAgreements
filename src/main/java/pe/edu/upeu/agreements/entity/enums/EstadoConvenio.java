package pe.edu.upeu.agreements.entity.enums;

/**
 * Estado enum for Convenio entity
 */
public enum EstadoConvenio {
    VIGENTE("Vigente"),
    VENCIDO("Vencido"),
    POR_VENCER("Por vencer");

    private final String displayName;

    EstadoConvenio(String displayName) {
        this.displayName = displayName;
    }

    public String getDisplayName() {
        return displayName;
    }
}