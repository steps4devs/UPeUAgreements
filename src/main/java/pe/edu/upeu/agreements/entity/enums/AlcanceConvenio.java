package pe.edu.upeu.agreements.entity.enums;

/**
 * Alcance enum for Convenio entity
 */
public enum AlcanceConvenio {
    CARRERA("Carrera"),
    FACULTAD("Facultad"),
    UNIVERSIDAD("Universidad");

    private final String displayName;

    AlcanceConvenio(String displayName) {
        this.displayName = displayName;
    }

    public String getDisplayName() {
        return displayName;
    }
}