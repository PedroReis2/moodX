import React, { useEffect, useMemo, useState } from "react";
import axios from "axios";
import Navbar from "./Navbar";

function MoodboardCollage({ images }) {
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

    return (
        <div className="mb__collage">
            {rows.map((row, rowIndex) => (
                <div key={rowIndex} className="mb__collage-row">
                    {row.map((url, i) => (
                        <div key={`${rowIndex}-${i}`} className="mb__collage-item">
                            <img src={url} alt="Moodboard reference" />
                        </div>
                    ))}
                </div>
            ))}
        </div>
    );
}

export default function MyMoodboards({ userName = "" }) {
    const [moodboards, setMoodboards] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios
            .get("/my-moodboards-data")
            .then(({ data }) => setMoodboards(data.moodboards))
            .finally(() => setLoading(false));
    }, []);

    const remove = async (moodboard) => {
        if (!window.confirm(`Delete the moodboard "${moodboard.title}"?`)) return;
        try {
            await axios.delete(`/moodboard/${moodboard.id}`);
            setMoodboards((prev) => prev.filter((m) => m.id !== moodboard.id));
        } catch {
            // silencioso
        }
    };

    const togglePublic = async (moodboard) => {
        try {
            const { data } = await axios.patch(`/moodboard/${moodboard.id}/toggle-public`);
            setMoodboards((prev) =>
                prev.map((m) => (m.id === moodboard.id ? data.moodboard : m))
            );
        } catch {
            // silencioso
        }
    };

    return (
        <div className="mb">
            <Navbar userName={userName} page="my-moodboards" />

            <main className="mb__main">
                <header className="mb__header">
                    <p className="mb__kicker">MOOD.X — Creative Studio</p>
                    <h1 className="mb__title">My Moodboards</h1>
                    <p className="mb__subtitle">
                        Your Creative DNA combined with your projects.
                    </p>
                    <button
                        type="button"
                        className="mb__btn mb__btn--solid"
                        style={{ marginTop: 20 }}
                        onClick={() => (window.location.href = "/moodboard")}
                    >
                        New Moodboard
                    </button>
                </header>

                {loading ? (
                    <p className="mb__loading">Loading...</p>
                ) : moodboards.length === 0 ? (
                    <div className="mb__empty">
                        <p className="mb__empty-text">
                            You don't have any moodboards yet.
                        </p>
                    </div>
                ) : (
                    moodboards.map((moodboard) => (
                        <section key={moodboard.id} style={{ marginBottom: 56 }}>
                            <div
                                style={{
                                    display: "flex",
                                    justifyContent: "space-between",
                                    alignItems: "center",
                                    marginBottom: 16,
                                }}
                            >
                                <h2 className="mb__card-title" style={{ fontSize: 22 }}>
                                    {moodboard.title}
                                </h2>
                                <div style={{ display: "flex", gap: 16, alignItems: "center" }}>
                                    <span className="mb__card-count">
                                        ♥ {moodboard.likesCount}
                                    </span>
                                    <button
                                        type="button"
                                        className="mb__link"
                                        onClick={() => togglePublic(moodboard)}
                                    >
                                        {moodboard.isPublic ? "Make Private" : "Make Public"}
                                    </button>
                                    <button
                                        type="button"
                                        className="mb__link mb__link--danger"
                                        onClick={() => remove(moodboard)}
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>

                            <span className="mb__card-count">
                                {moodboard.isPublic ? "Public" : "Private"}
                            </span>

                            {moodboard.description && (
                                <p
                                    style={{
                                        margin: "12px 0 20px",
                                        fontSize: 15,
                                        fontWeight: 300,
                                        color: "#3a3a3a",
                                        lineHeight: 1.6,
                                    }}
                                >
                                    {moodboard.description}
                                </p>
                            )}

                            {moodboard.palette.length > 0 && (
                                <div className="mb__palette mb__palette--dna">
                                    {moodboard.palette.map((color, i) => (
                                        <span
                                            key={`${color.hex}-${i}`}
                                            className="mb__palette-swatch"
                                            style={{ backgroundColor: color.hex }}
                                            title={`${color.hex} (${color.source})`}
                                        />
                                    ))}
                                </div>
                            )}

                            <MoodboardCollage images={moodboard.images} />
                        </section>
                    ))
                )}
            </main>
        </div>
    );
}