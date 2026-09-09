import React, { useEffect, useState } from "react";
import axios from "axios";
import Navbar from "./Navbar";

const formatDate = (iso) => {
    if (!iso) return "";
    const d = new Date(`${iso}T00:00:00`);
    if (Number.isNaN(d.getTime())) return iso;
    return d.toLocaleDateString("en-GB", {
        day: "numeric",
        month: "short",
        year: "numeric",
    });
};

const formatClassName = (cls) => {
    if (!cls.code) return cls.name;

    return `${cls.name} - ${cls.code}`;
};

export default function Classes({ userName = "" }) {
    const [classes, setClasses] = useState([]);
    const [loading, setLoading] = useState(true);
    const [toast, setToast] = useState(null);
    const [feedbackDrafts, setFeedbackDrafts] = useState({});
    const [savingProjectId, setSavingProjectId] = useState(null);

    const showToast = (message, type = "error") => {
        setToast({ message, type });
        setTimeout(() => setToast(null), 4000);
    };

    const loadClasses = async () => {
        try {
            const { data } = await axios.get("/classes/data");
            setClasses(data.classes);

            // Guarda o feedback que já existe para cada projeto.
            // Assim o professor pode editar o texto sem criar campos soltos.
            setFeedbackDrafts(
                Object.fromEntries(
                    data.classes.flatMap((cls) =>
                        cls.projects.map((project) => [
                            project.id,
                            project.teacherFeedback || "",
                        ]),
                    ),
                ),
            );
        } catch (err) {
            showToast(
                err.response?.data?.message || "Unable to load your classes.",
            );
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        loadClasses();
    }, []);

    const saveFeedback = async (projectId) => {
        const content = (feedbackDrafts[projectId] || "").trim();

        if (!content) {
            showToast("Write feedback before saving.");
            return;
        }

        setSavingProjectId(projectId);

        try {
            await axios.post(`/classes/projects/${projectId}/feedback`, {
                content,
            });
            showToast("Feedback saved.", "success");
            await loadClasses();
        } catch (err) {
            showToast(
                err.response?.data?.message || "Unable to save feedback.",
            );
        } finally {
            setSavingProjectId(null);
        }
    };

    return (
        <div className="mb">
            {toast && (
                <div className={`mb-toast mb-toast--${toast.type}`}>
                    {toast.message}
                </div>
            )}

            <Navbar userName={userName} page="classes" isProfessor />

            <main className="mb__main">
                <header className="mb__header">
                    <p className="mb__kicker">MOOD.X — Creative Studio</p>
                    <h1 className="mb__title">Classes</h1>
                    <p className="mb__subtitle">
                        The classes you teach and the projects your students
                        created.
                    </p>
                </header>

                {loading ? (
                    <p className="mb__loading">Loading classes...</p>
                ) : classes.length === 0 ? (
                    <div className="mb__empty">
                        <p className="mb__empty-text">
                            You do not have any classes assigned yet.
                        </p>
                    </div>
                ) : (
                    <div className="cls__list">
                        {classes.map((cls) => (
                            <section key={cls.id} className="cls__card">
                                <header className="cls__card-head">
                                    <h2 className="cls__card-name">
                                        {formatClassName(cls)}
                                    </h2>
                                    <span className="cls__card-count">
                                        {cls.projects.length}{" "}
                                        {cls.projects.length === 1
                                            ? "project"
                                            : "projects"}
                                    </span>
                                </header>

                                {cls.projects.length === 0 ? (
                                    <p className="cls__empty">
                                        There are no student projects in this
                                        class yet.
                                    </p>
                                ) : (
                                    <div className="cls__grid">
                                        {cls.projects.map((p) => (
                                            <article
                                                key={p.id}
                                                className="cls__project"
                                            >
                                                <div
                                                    className="cls__project-cover"
                                                    style={
                                                        p.coverUrl
                                                            ? {
                                                                  backgroundImage: `url(${p.coverUrl})`,
                                                              }
                                                            : p.palette &&
                                                              p.palette.length
                                                            ? {
                                                                  background: `linear-gradient(135deg, ${
                                                                      p.palette[0]
                                                                  } 0%, ${
                                                                      p.palette[1] ||
                                                                      p.palette[0]
                                                                  } 100%)`,
                                                              }
                                                            : undefined
                                                    }
                                                >
                                                    {!p.coverUrl && (
                                                        <span className="cls__project-monogram">
                                                            {p.title
                                                                .trim()
                                                                .charAt(0)
                                                                .toUpperCase()}
                                                        </span>
                                                    )}
                                                </div>
                                                <div className="cls__project-body">
                                                    <h3 className="cls__project-title">
                                                        {p.title}
                                                    </h3>
                                                    <p className="cls__project-student">
                                                        by {p.student}
                                                    </p>
                                                    <p className="cls__project-date">
                                                        {formatDate(p.date)} ·{" "}
                                                        {p.imageCount} images
                                                    </p>

                                                    {p.palette &&
                                                        p.palette.length > 0 && (
                                                            <div className="cls__palette">
                                                                {p.palette.map(
                                                                    (hex) => (
                                                                        <span
                                                                            key={
                                                                                hex
                                                                            }
                                                                            className="cls__palette-swatch"
                                                                            style={{
                                                                                backgroundColor:
                                                                                    hex,
                                                                            }}
                                                                            title={
                                                                                hex
                                                                            }
                                                                        />
                                                                    ),
                                                                )}
                                                            </div>
                                                        )}

                                                    <div className="cls__feedback">
                                                        <label className="cls__feedback-label">
                                                            Teacher feedback
                                                        </label>
                                                        <textarea
                                                            className="cls__feedback-input"
                                                            value={
                                                                feedbackDrafts[
                                                                    p.id
                                                                ] || ""
                                                            }
                                                            onChange={(e) =>
                                                                setFeedbackDrafts(
                                                                    (
                                                                        current,
                                                                    ) => ({
                                                                        ...current,
                                                                        [p.id]: e
                                                                            .target
                                                                            .value,
                                                                    }),
                                                                )
                                                            }
                                                            rows={4}
                                                            placeholder="Write feedback for this student project..."
                                                        />
                                                        <button
                                                            type="button"
                                                            className="mb__btn mb__btn--solid cls__feedback-btn"
                                                            disabled={
                                                                savingProjectId ===
                                                                p.id
                                                            }
                                                            onClick={() =>
                                                                saveFeedback(
                                                                    p.id,
                                                                )
                                                            }
                                                        >
                                                            {savingProjectId ===
                                                            p.id
                                                                ? "Saving..."
                                                                : "Save feedback"}
                                                        </button>
                                                    </div>
                                                </div>
                                            </article>
                                        ))}
                                    </div>
                                )}
                            </section>
                        ))}
                    </div>
                )}
            </main>
        </div>
    );
}
