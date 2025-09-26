package pe.edu.upeu.agreements.entity.enums;

/**
 * TipoDocumento enum for DocumentoConvenio entity
 */
public enum TipoDocumento {
    PDF("PDF"),
    IMAGEN("Imagen"),
    OTRO("Otro");

    private final String displayName;

    TipoDocumento(String displayName) {
        this.displayName = displayName;
    }

    public String getDisplayName() {
        return displayName;
    }
}