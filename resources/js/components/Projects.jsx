import React, { useEffect, useRef, useState } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import { Carousel } from "react-bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";

const MIN_IMAGES = 4;
const MAX_IMAGES = 5;

export default function Projects({ userName = "" }) {
    const [projects, setProjects] = useState([]);
    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);

    const [modalOpen, setModalOpen] = useState(false);
    const [editing, setEditing] = useState(null);
    const [title, setTitle] = useState("");
    const [images, setImages] = useState([]);

    const [deleteAllOpen, setDeleteAllOpen] = useState(false);
    const [deletingAll, setDeletingAll] = useState(false);

    const [toast, setToast] = useState(null);
    const fileInputRef = useRef(null);

    // Estado para controlar o índice do carrossel em cada card
    const [carouselStates, setCarouselStates] = useState({});

    const showToast = (message, type = "error") => {
        setToast({ message, type });
        setTimeout(() => setToast(null), 4000);
    };

    const loadData = async () => {
        try {
            const { data } = await axios.get("/projects/data");
            setProjects(data.projects);
        } catch (err) {
            showToast(
                err.response?.data?.message || "Unable to load your projects."
            );
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        loadData();
    }, []);

    const openCreate = () => {
        setEditing(null);
        setTitle("");
        setImages([]);
        setModalOpen(true);
    };

    const openEdit = (project) => {
        setEditing(project);
        setTitle(project.title);
        setImages(
            project.imageUrls.map((url, i) => ({
                key: `${project.id}-${i}`,
                type: "existing",
                path: project.images[i],
                url,
            }))
        );
        setModalOpen(true);
    };

    const closeModal = () => {
        if (saving) return;
        setModalOpen(false);
    };

    const handleFiles = (fileList) => {
        const files = Array.from(fileList || []).filter((f) =>
            f.type.startsWith("image/")
        );
        if (files.length === 0) return;

        setImages((prev) => {
            const room = MAX_IMAGES - prev.length;
            if (files.length > room) {
                showToast(
                    `A project can contain a maximum of ${MAX_IMAGES} images.`
                );
            }
            const kept = files.slice(0, Math.max(room, 0));
            return [
                ...prev,
                ...kept.map((file) => ({
                    key: `${file.name}-${file.lastModified}-${Math.random()
                        .toString(36)
                        .slice(2)}`,
                    type: "new",
                    file,
                    url: URL.createObjectURL(file),
                })),
            ];
        });
    };

    const removeImage = (key) => {
        setImages((prev) => {
            const item = prev.find((i) => i.key === key);
            if (item && item.type === "new" && item.url) {
                URL.revokeObjectURL(item.url);
            }
            return prev.filter((i) => i.key !== key);
        });
    };

    const handleCarouselSelect = (projectId, selectedIndex) => {
        setCarouselStates((prev) => ({
            ...prev,
            [projectId]: selectedIndex,
        }));
    };

    const save = async () => {
        if (!title.trim()) {
            showToast("Give your project a title.");
            return;
        }
        if (images.length < MIN_IMAGES || images.length > MAX_IMAGES) {
            showToast(
                `A project must contain between ${MIN_IMAGES} and ${MAX_IMAGES} images.`
            );
            return;
        }

        setSaving(true);
        const data = new FormData();
        data.append("title", title.trim());
        images
            .filter((i) => i.type === "existing")
            .forEach((i) => data.append("existing[]", i.path));
        images
            .filter((i) => i.type === "new")
            .forEach((i) => data.append("files[]", i.file));

        try {
            if (editing) {
                const { data: res } = await axios.put(
                    `/projects/${editing.id}`,
                    data
                );
                setProjects((prev) =>
                    prev.map((p) => (p.id === editing.id ? res.project : p))
                );
                showToast("Project updated.", "success");
            } else {
                const { data: res } = await axios.post("/projects", data);
                setProjects((prev) => [res.project, ...prev]);
                showToast("Project created.", "success");
            }
            setModalOpen(false);
        } catch (err) {
            if (err.response?.status === 403) {
                showToast("You don't have permission to modify this project.");
                return;
            }
            const msgs = Object.values(err.response?.data?.errors ?? {}).flat();
            showToast(
                msgs.length
                    ? msgs[0]
                    : err.response?.data?.message ||
                          "Unable to save the project."
            );
        } finally {
            setSaving(false);
        }
    };

    const remove = async (project) => {
        if (!window.confirm(`Delete the project "${project.title}"?`)) return;
        try {
            await axios.delete(`/projects/${project.id}`);
            setProjects((prev) => prev.filter((p) => p.id !== project.id));
            showToast("Project deleted.", "success");
        } catch (err) {
            if (err.response?.status === 403) {
                showToast("You don't have permission to delete this project.");
                return;
            }
            showToast(
                err.response?.data?.message || "Unable to delete the project."
            );
        }
    };

    const deleteAll = async () => {
        setDeletingAll(true);
        try {
            await axios.delete("/projects");
            setProjects([]);
            setDeleteAllOpen(false);
            showToast("All projects deleted.", "success");
        } catch (err) {
            showToast(
                err.response?.data?.message || "Unable to delete your projects."
            );
        } finally {
            setDeletingAll(false);
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
                page="projects"
                actions={[
                    {
                        label: "New Project",
                        onClick: openCreate,
                        variant: "solid",
                    },
                ]}
            />

            <main className="mb__main">
                <header className="mb__header">
                    <p className="mb__kicker">MOOD.X — Creative Studio</p>
                    <h1 className="mb__title">Projects</h1>
                    <p className="mb__subtitle">
                        Create your fashion projects with your references.
                    </p>
                </header>

                {loading ? (
                    <p className="mb__loading">Loading...</p>
                ) : projects.length === 0 ? (
                    <div className="mb__empty">
                        <span className="mb__empty-icon">+</span>
                        <p className="mb__empty-text">
                            You don't have any projects yet.
                        </p>
                        <button
                            type="button"
                            className="mb__btn mb__btn--solid"
                            onClick={openCreate}
                        >
                            Create your first project
                        </button>
                    </div>
                ) : (
                    <div className="mb__grid">
                        {projects.map((project) => (
                            <article key={project.id} className="mb__card">
                                {/* CARROSSEL NO CARD */}
                                {project.imageUrls &&
                                project.imageUrls.length > 0 ? (
                                    <div className="mb__card-carousel">
                                        <Carousel
                                            activeIndex={
                                                carouselStates[project.id] || 0
                                            }
                                            onSelect={(index) =>
                                                handleCarouselSelect(
                                                    project.id,
                                                    index
                                                )
                                            }
                                            interval={2000}
                                            indicators={false}
                                            controls={true}
                                            pause="hover"
                                            className="card-carousel"
                                        >
                                            {project.imageUrls.map(
                                                (url, idx) => (
                                                    <Carousel.Item key={idx}>
                                                        <img
                                                            className="d-block w-100"
                                                            src={url}
                                                            alt={`${
                                                                project.title
                                                            } - ${idx + 1}`}
                                                            style={{
                                                                height: "250px",
                                                                objectFit:
                                                                    "cover",
                                                                width: "100%",
                                                            }}
                                                        />
                                                    </Carousel.Item>
                                                )
                                            )}
                                        </Carousel>
                                    </div>
                                ) : (
                                    <div className="mb__card-cover" />
                                )}

                                <div className="mb__card-body">
                                    <h2 className="mb__card-title">
                                        {project.title}
                                    </h2>
                                    <span className="mb__card-count">
                                        {project.images.length}{" "}
                                        {project.images.length === 1
                                            ? "image"
                                            : "images"}
                                    </span>
                                    {/* Mostrar os quadradinhos com as cores geradas para este projeto. */}
                                    {project.palette?.length > 0 && (
                                        <div className="mb__palette">
                                            {project.palette.map((color) => (
                                                <span
                                                    key={`${project.id}-${color.hex}`}
                                                    className="mb__palette-swatch"
                                                    style={{
                                                        backgroundColor:
                                                            color.hex,
                                                    }}
                                                    title={`${
                                                        color.hex
                                                    } - score ${Math.round(
                                                        color.score
                                                    )}`}
                                                />
                                            ))}
                                        </div>
                                    )}
                                    <div className="mb__card-actions">
                                        <button
                                            type="button"
                                            className="mb__link"
                                            onClick={() => openEdit(project)}
                                        >
                                            Edit
                                        </button>
                                        <button
                                            type="button"
                                            className="mb__link mb__link--danger"
                                            onClick={() => remove(project)}
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </article>
                        ))}
                    </div>
                )}

                {projects.length > 0 && (
                    <div className="mb__footer">
                        <button
                            type="button"
                            className="mb__btn mb__btn--danger"
                            disabled={projects.length < 2 || deletingAll}
                            onClick={() => setDeleteAllOpen(true)}
                        >
                            {deletingAll
                                ? "Deleting..."
                                : "Delete all projects"}
                        </button>
                    </div>
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
                                {editing ? "Edit project" : "New project"}
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

                        <label
                            className="mb-field__label"
                            htmlFor="project-title"
                        >
                            Project title
                        </label>
                        <input
                            id="project-title"
                            className="mb-field__input"
                            type="text"
                            value={title}
                            onChange={(e) => setTitle(e.target.value)}
                            placeholder="e.g. Winter 2026 Collection"
                            maxLength={100}
                        />

                        <div className="mb-picker__meta">
                            <span className="mb-picker__label">
                                Upload {MIN_IMAGES} to {MAX_IMAGES} images for
                                the project
                            </span>
                            <span
                                className={`mb-picker__count ${
                                    images.length >= MIN_IMAGES
                                        ? "mb-picker__count--ok"
                                        : ""
                                }`}
                            >
                                {images.length} / {MAX_IMAGES}
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
                            className="mb-upload"
                            onClick={() => fileInputRef.current?.click()}
                            onDragOver={(e) => e.preventDefault()}
                            onDrop={(e) => {
                                e.preventDefault();
                                handleFiles(e.dataTransfer.files);
                            }}
                        >
                            <span className="mb-upload__icon">+</span>
                            <p className="mb-upload__text">
                                Click or drag your images here
                            </p>
                            <p className="mb-upload__hint">
                                JPG, PNG — between {MIN_IMAGES} and {MAX_IMAGES}{" "}
                                files
                            </p>
                        </div>

                        {images.length > 0 && (
                            <div className="mb-previews">
                                {images.map((img) => (
                                    <div key={img.key} className="mb-preview">
                                        <img
                                            className="mb-preview__img"
                                            src={img.url}
                                            alt=""
                                        />
                                        <button
                                            type="button"
                                            className="mb-preview__remove"
                                            onClick={() => removeImage(img.key)}
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
                                {saving
                                    ? "Saving..."
                                    : editing
                                    ? "Save changes"
                                    : "Create project"}
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {deleteAllOpen && (
                <div
                    className="mb-confirm"
                    onClick={() => {
                        if (!deletingAll) setDeleteAllOpen(false);
                    }}
                >
                    <div
                        className="mb-confirm__panel"
                        onClick={(e) => e.stopPropagation()}
                    >
                        <h3 className="mb-confirm__title">
                            Delete all projects
                        </h3>
                        <p className="mb-confirm__text">
                            Are you sure you want to delete your projects?
                        </p>
                        <div className="mb-confirm__actions">
                            <button
                                type="button"
                                className="mb__btn mb__btn--ghost"
                                disabled={deletingAll}
                                onClick={() => setDeleteAllOpen(false)}
                            >
                                CANCEL
                            </button>
                            <button
                                type="button"
                                className="mb__btn mb__btn--solid"
                                disabled={deletingAll}
                                onClick={deleteAll}
                            >
                                {deletingAll ? "Deleting..." : "YES"}
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}
