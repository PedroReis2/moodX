import React, { useEffect, useMemo, useState } from "react";
import axios from "axios";
import Navbar from "./Navbar";
import ImagePreviewModal from "./ImagePreviewModal";

function MoodboardCollage({ images, onImageClick }) {
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
                        <div
                            key={`${rowIndex}-${i}`}
                            className="mb__collage-item"
                        >
                            <img
                                src={url}
                                alt="Moodboard reference"
                                onClick={() => onImageClick(url)}
                            />
                        </div>
                    ))}
                </div>
            ))}
        </div>
    );
}

export default function Gallery({ userName = "" }) {
    const [moodboards, setMoodboards] = useState([]);
    const [loading, setLoading] = useState(true);
    const [selectedImage, setSelectedImage] = useState(null);

    useEffect(() => {
        axios
            .get("/gallery-data")
            .then(({ data }) => setMoodboards(data.moodboards))
            .finally(() => setLoading(false));
    }, []);

    const toggleLike = async (moodboard) => {
        try {
            const { data } = await axios.post(
                `/moodboard/${moodboard.id}/like`,
            );
            setMoodboards((prev) =>
                prev.map((m) =>
                    m.id === moodboard.id
                        ? {
                              ...m,
                              likedByUser: data.liked,
                              likesCount: data.likesCount,
                          }
                        : m,
                ),
            );
        } catch {
            // silencioso
        }
    };

    return (
        <div className="mb">
            <Navbar userName={userName} page="gallery" />

            <main className="mb__main">
                <header className="mb__header">
                    <p className="mb__kicker">MOOD.X — Creative Studio</p>
                    <h1 className="mb__title">Gallery</h1>
                    <p className="mb__subtitle">
                        Public moodboards from the mood.x community.
                    </p>
                </header>

                {loading ? (
                    <p className="mb__loading">Loading...</p>
                ) : moodboards.length === 0 ? (
                    <div className="mb__empty">
                        <p className="mb__empty-text">
                            No public moodboards yet. Be the first to share one!
                        </p>
                    </div>
                ) : (
                    moodboards.map((moodboard) => (
                        <section
                            key={moodboard.id}
                            style={{ marginBottom: 56 }}
                        >
                            <div
                                style={{
                                    display: "flex",
                                    justifyContent: "space-between",
                                    alignItems: "center",
                                    marginBottom: 16,
                                }}
                            >
                                <div>
                                    <h2
                                        className="mb__card-title"
                                        style={{ fontSize: 22 }}
                                    >
                                        {moodboard.title}
                                    </h2>
                                    <span className="mb__card-count">
                                        by {moodboard.authorName}
                                    </span>
                                </div>
                                <button
                                    type="button"
                                    className="mb__link"
                                    onClick={() => toggleLike(moodboard)}
                                >
                                    {moodboard.likedByUser ? "♥" : "♡"}{" "}
                                    {moodboard.likesCount}
                                </button>
                            </div>

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
                                            style={{
                                                backgroundColor: color.hex,
                                            }}
                                            title={`${color.hex} (${color.source})`}
                                        />
                                    ))}
                                </div>
                            )}

                            <MoodboardCollage
                                images={moodboard.images}
                                onImageClick={setSelectedImage}
                            />
                        </section>
                    ))
                )}
            </main>
            <ImagePreviewModal
                imageUrl={selectedImage}
                alt="Moodboard reference"
                onClose={() => setSelectedImage(null)}
            />
        </div>
    );
}
