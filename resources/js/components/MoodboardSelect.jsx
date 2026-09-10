import React, { useEffect, useState } from "react";
import axios from "axios";
import Navbar from "./Navbar";

const MIN_PROJECTS = 1; // minimo de 1 projeto por moodboard
const MAX_PROJECTS = 5; // maximo de 5 projetos por moodboard

export default function MoodboardSelect({ userName = "", isProfessor = false }) {
    const [projects, setProjects] = useState([]);
    const [loading, setLoading] = useState(true);
    const [selected, setSelected] = useState([]);
    const [title, setTitle] = useState("");
    const [description, setDescription] = useState("");
    const [isPublic, setIsPublic] = useState(false);
    const [saving, setSaving] = useState(false);
    const [toast, setToast] = useState(null);

    const showToast = (message, type = "error") => {
        setToast({ message, type });
        setTimeout(() => setToast(null), 4000);
    };

    useEffect(() => {
        axios
            .get("/moodboard-select-data")
            .then(({ data }) => setProjects(data.projects))
            .finally(() => setLoading(false));
    }, []);

    const toggleProject = (id) => {
        setSelected((prev) => {
            if (prev.includes(id)) {
                return prev.filter((p) => p !== id);
            }
            if (prev.length >= MAX_PROJECTS) {
                showToast(`You can select a maximum of ${MAX_PROJECTS} projects.`);
                return prev;
            }
            return [...prev, id];
        });
    };

    const generate = async () => {
        if (!title.trim()) {
            showToast("Give your moodboard a title.");
            return;
        }
        if (selected.length < MIN_PROJECTS) {
            showToast(`Select at least ${MIN_PROJECTS} projects.`);
            return;
        }

        setSaving(true);
        try {
            await axios.post("/moodboard", {
                title: title.trim(),
                description: description.trim(),
                project_ids: selected,
                is_public: isPublic,
            });
            showToast("Moodboard created.", "success");
            setTimeout(() => (window.location.href = "/my-moodboards"), 700);
        } catch (err) {
            const msgs = Object.values(err.response?.data?.errors ?? {}).flat();
            showToast(
                msgs.length ? msgs[0] : err.response?.data?.message || "Unable to create moodboard."
            );
        } finally {
            setSaving(false);
        }
    };

    return (
        <div className="mb">
            {toast && (
                <div className={`mb-toast mb-toast--${toast.type}`}>{toast.message}</div>
            )}

            <Navbar
                userName={userName}
                page="moodboard"
                isProfessor={isProfessor}
            />

            <main className="mb__main">
                <header className="mb__header">
                    <p className="mb__kicker">MOOD.X — Creative Studio</p>
                    <h1 className="mb__title">Create Moodboard</h1>
                    <p className="mb__subtitle">
                        Select {MIN_PROJECTS} to {MAX_PROJECTS} projects to combine into a moodboard.
                    </p>
                </header>

                <label className="mb-field__label" htmlFor="moodboard-title">
                    Moodboard title
                </label>
                <input
                    id="moodboard-title"
                    className="mb-field__input"
                    type="text"
                    value={title}
                    onChange={(e) => setTitle(e.target.value)}
                    placeholder="e.g. Winter Collection Moodboard"
                    maxLength={100}
                />

                <label className="mb-field__label" htmlFor="moodboard-description">
                    Description / Narrative
                </label>
                <textarea
                    id="moodboard-description"
                    className="mb-field__input"
                    value={description}
                    onChange={(e) => setDescription(e.target.value)}
                    placeholder="Tell the story behind this moodboard — the mood, the memory, the inspiration..."
                    maxLength={2000}
                    rows={5}
                    style={{ resize: "vertical", fontFamily: "inherit" }}
                />

                <label
                    className="mb-field__label"
                    style={{ display: "flex", alignItems: "center", gap: 10, cursor: "pointer" }}
                >
                    <input
                        type="checkbox"
                        checked={isPublic}
                        onChange={(e) => setIsPublic(e.target.checked)}
                    />
                    Make this moodboard public (visible in the Gallery)
                </label>

                {loading ? (
                    <p className="mb__loading">Loading...</p>
                ) : projects.length === 0 ? (
                    <div className="mb__empty">
                        <p className="mb__empty-text">
                            You don't have any projects yet. Create a project first.
                        </p>
                    </div>
                ) : (
                    <div className="mb__grid mb__grid--dna">
                        {projects.map((project) => {
                            const isSelected = selected.includes(project.id);
                            return (
                                <article
                                    key={project.id}
                                    className={`mb__card mb__card--dna ${isSelected ? "mb__card--selected" : ""}`}
                                    onClick={() => toggleProject(project.id)}
                                    style={{ cursor: "pointer" }}
                                >
                                    {project.coverUrl ? (
                                        <img
                                            className="mb__card-cover"
                                            src={project.coverUrl}
                                            alt={project.title}
                                        />
                                    ) : (
                                        <div className="mb__card-cover" />
                                    )}
                                    <div className="mb__card-body">
                                        <h2 className="mb__card-title">{project.title}</h2>
                                        {isSelected && (
                                            <span className="mb__card-count">Selected</span>
                                        )}
                                    </div>
                                </article>
                            );
                        })}
                    </div>
                )}

                <div className="mb__footer">
                    <button
                        type="button"
                        className="mb__btn mb__btn--solid"
                        disabled={saving || selected.length < MIN_PROJECTS}
                        onClick={generate}
                    >
                        {saving ? "Generating..." : `Generate Moodboard (${selected.length}/${MAX_PROJECTS})`}
                    </button>
                </div>
            </main>
        </div>
    );
}
