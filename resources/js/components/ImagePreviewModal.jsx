import React, { useEffect } from "react";

export default function ImagePreviewModal({
    imageUrl,
    alt = "Expanded image",
    onClose,
}) {
    useEffect(() => {
        if (!imageUrl) return;

        // Fecho a imagem também com a tecla Escape para ficar mais natural.
        const closeOnEscape = (event) => {
            if (event.key === "Escape") {
                onClose();
            }
        };

        window.addEventListener("keydown", closeOnEscape);

        return () => {
            window.removeEventListener("keydown", closeOnEscape);
        };
    }, [imageUrl, onClose]);

    if (!imageUrl) return null;

    return (
        <div
            className="image-preview-modal"
            onClick={onClose}
            role="dialog"
            aria-modal="true"
        >
            <button
                type="button"
                className="image-preview-modal__close"
                onClick={onClose}
                aria-label="Close image preview"
            >
                X
            </button>

            <img
                className="image-preview-modal__img"
                src={imageUrl}
                alt={alt}
                onClick={(event) => event.stopPropagation()}
            />
        </div>
    );
}
