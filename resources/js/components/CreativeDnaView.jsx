import React, { useEffect, useMemo, useRef, useState } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import ImagePreviewModal from "./ImagePreviewModal";

const MIN_FILES = 20;
const MAX_FILES = 30;

export default function CreativeDnaView({ userName = "", isProfessor = false }) {
    const [images, setImages] = useState([]);
    const [palette, setPalette] = useState([]);
    const [loading, setLoading] = useState(true);

    const [modalOpen, setModalOpen] = useState(false);
    const [files, setFiles] = useState([]);
    const [saving, setSaving] = useState(false);
    const [toast, setToast] = useState(null);
    const [dragging, setDragging] = useState(false);
    const fileInputRef = useRef(null);
    const [selectedImage, setSelectedImage] = useState(null);

    const showToast = (message, type = "error") => {
        setToast({ message, type });
        setTimeout(() => setToast(null), 4000);
    };

    const loadData = () => {
        axios
            .get("/creative-dna/data")
            .then(({ data }) => {
                setImages(data.images);
                setPalette(data.palette);
            })
            .finally(() => setLoading(false));
    };

    useEffect(() => {
        loadData();
    }, []);

    const rows = useMemo(() => {
        const n = images.length;
        if (n === 0) return [];

        const cols = Math.max(1, Math.round(Math.sqrt(n * 1.6)));
        const result = [];
        for (let i = 0; i < n; i += cols) {
            result.push(images.slice(i, i + cols));
        }
        return result;
    }, [images]);

    const openEdit = () => {
        setFiles([]);
        setModalOpen(true);
    };

    const closeModal = () => {
        if (saving) return;
        files.forEach((item) => URL.revokeObjectURL(item.url));
        setModalOpen(false);
    };

    const handleFiles = (fileList) => {
        const selected = Array.from(fileList || []).filter((f) =>
            f.type.startsWith("image/"),
        );
        if (selected.length === 0) return;

        setFiles((prev) => {
            const room = MAX_FILES - prev.length;
            if (selected.length > room) {
                showToast(`You can upload a maximum of ${MAX_FILES} images.`);
            }
            const kept = selected.slice(0, Math.max(room, 0));
            return [
                ...prev,
                ...kept.map((file) => ({
                    key: `${file.name}-${file.lastModified}-${Math.random()
                        .toString(36)
                        .slice(2)}`,
                    file,
                    url: URL.createObjectURL(file),
                })),
            ];
        });
    };

    const removeFile = (key) => {
        setFiles((prev) => {
            const item = prev.find((i) => i.key === key);
            if (item) URL.revokeObjectURL(item.url);
            return prev.filter((i) => i.key !== key);
        });
    };

    const save = async () => {
        if (files.length < MIN_FILES || files.length > MAX_FILES) {
            showToast(
                `Select between ${MIN_FILES} and ${MAX_FILES} images to update your Creative DNA.`,
            );
            return;
        }

        setSaving(true);
        const data = new FormData();
        files.forEach(({ file }) => data.append("files[]", file));

        try {
            await axios.post("/creative-dna/upload", data);
            showToast("Creative DNA updated.", "success");
            setModalOpen(false);
            setLoading(true);
            loadData();
        } catch (err) {
            const msgs = Object.values(err.response?.data?.errors ?? {}).flat();
            showToast(
                msgs.length
                    ? msgs[0]
                    : err.response?.data?.message ||
                          "Unable to update Creative DNA.",
            );
        } finally {
            setSaving(false);
        }
    };

    return (
        <div className="mb">
            {toast && (
                <div className={`mb-toast mb-toast--${toast.type}`}>
                    {toast.message}
                </div>
            )}

            <Navbar
                userName={userName}
                page="creative-dna"
                isProfessor={isProfessor}
            />

            <main className="mb__main">
                <header className="mb__header">
                    <p className="mb__kicker">MOOD.X — Creative Studio</p>
                    <h1 className="mb__title">Your Creative DNA</h1>
                    <p className="mb__subtitle">
                        The images that define your style as a designer.
                    </p>
                </header>

                {loading ? (
                    <p className="mb__loading">Loading...</p>
                ) : (
                    <>
                        {palette.length > 0 && (
                            <div className="mb__palette mb__palette--dna">
                                {palette.map((color) => (
                                    <span
                                        key={color.hex}
                                        className="mb__palette-swatch"
                                        style={{ backgroundColor: color.hex }}
                                        title={`${color.hex} - score ${Math.round(
                                            color.score,
                                        )}`}
                                    />
                                ))}
                            </div>
                        )}

                        <div className="mb__collage">
                            {rows.map((row, rowIndex) => (
                                <div key={rowIndex} className="mb__collage-row">
                                    {row.map((img) => (
                                        <div
                                            key={img.id}
                                            className="mb__collage-item"
                                        >
                                            <img
                                                src={img.url}
                                                alt="Creative DNA reference"
                                                onClick={() =>
                                                    setSelectedImage(img.url)
                                                }
                                            />
                                        </div>
                                    ))}
                                </div>
                            ))}
                        </div>

                        <div className="mb__footer">
                            <button
                                type="button"
                                className="mb__btn mb__btn--solid"
                                onClick={openEdit}
                            >
                                Update Creative DNA
                            </button>
                        </div>
                    </>
                )}
            </main>

            {modalOpen && (
                <div className="mb-modal" onClick={closeModal}>
                    <div
                        className="mb-modal__panel"
                        onClick={(e) => e.stopPropagation()}
                    >
                        <div className="mb-modal__head">
                            <h2 className="mb-modal__title">
                                Update Creative DNA
                            </h2>
                            <button
                                type="button"
                                className="mb-modal__close"
                                onClick={closeModal}
                                aria-label="Close"
                            >
                                &times;
                            </button>
                        </div>

                        <p
                            style={{
                                fontSize: 14,
                                fontWeight: 300,
                                color: "#6f757e",
                                marginBottom: 20,
                            }}
                        >
                            Uploading new images replaces your entire Creative
                            DNA — select {MIN_FILES} to {MAX_FILES} images.
                        </p>

                        <div className="mb-picker__meta">
                            <span className="mb-picker__label">
                                Upload {MIN_FILES} to {MAX_FILES} images
                            </span>
                            <span
                                className={`mb-picker__count ${
                                    files.length >= MIN_FILES
                                        ? "mb-picker__count--ok"
                                        : ""
                                }`}
                            >
                                {files.length} / {MAX_FILES}
                            </span>
                        </div>

                        <input
                            ref={fileInputRef}
                            type="file"
                            accept="image/*"
                            multiple
                            hidden
                            onChange={(e) => {
                                handleFiles(e.target.files);
                                e.target.value = "";
                            }}
                        />

                        <div
                            className={`mb-upload ${
                                dragging ? "mb-upload--dragover" : ""
                            }`}
                            onClick={() => fileInputRef.current?.click()}
                            onDragEnter={(e) => {
                                e.preventDefault();
                                setDragging(true);
                            }}
                            onDragOver={(e) => e.preventDefault()}
                            onDragLeave={(e) => {
                                e.preventDefault();
                                setDragging(false);
                            }}
                            onDrop={(e) => {
                                e.preventDefault();
                                setDragging(false);
                                handleFiles(e.dataTransfer.files);
                            }}
                        >
                            <span className="mb-upload__icon">+</span>
                            <p className="mb-upload__text">
                                Click or drag your images here
                            </p>
                            <p className="mb-upload__hint">
                                JPG, PNG — between {MIN_FILES} and {MAX_FILES}{" "}
                                files
                            </p>
                        </div>

                        {files.length > 0 && (
                            <div className="mb-previews">
                                {files.map((img) => (
                                    <div key={img.key} className="mb-preview">
                                        <img
                                            className="mb-preview__img"
                                            src={img.url}
                                            alt=""
                                        />
                                        <button
                                            type="button"
                                            className="mb-preview__remove"
                                            onClick={() => removeFile(img.key)}
                                            aria-label="Remove"
                                        >
                                            &times;
                                        </button>
                                    </div>
                                ))}
                            </div>
                        )}

                        <div className="mb-modal__actions">
                            <button
                                type="button"
                                className="mb__btn mb__btn--ghost"
                                onClick={closeModal}
                                disabled={saving}
                            >
                                Cancel
                            </button>
                            <button
                                type="button"
                                className="mb__btn mb__btn--solid"
                                onClick={save}
                                disabled={saving}
                            >
                                {saving ? "Saving..." : "Save changes"}
                            </button>
                        </div>
                    </div>
                </div>
            )}
            <ImagePreviewModal
                imageUrl={selectedImage}
                alt="Creative DNA reference"
                onClose={() => setSelectedImage(null)}
            />
        </div>
    );
}
