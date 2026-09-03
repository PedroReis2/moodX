import React, { useEffect, useMemo, useState } from "react";
import axios from "axios";
import Navbar from "./Navbar";

export default function CreativeDnaView({ userName = "" }) {
    const [images, setImages] = useState([]);
    const [palette, setPalette] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios
            .get("/creative-dna/data")
            .then(({ data }) => {
                setImages(data.images);
                setPalette(data.palette);
            })
            .finally(() => setLoading(false));
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

    return (
        <div className="mb">
            <Navbar userName={userName} page="creative-dna" />

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
                                        style={{
                                            backgroundColor: color.hex,
                                        }}
                                        title={`${
                                            color.hex
                                        } - score ${Math.round(color.score)}`}
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
                                            />
                                        </div>
                                    ))}
                                </div>
                            ))}
                        </div>

                        <div className="mb__footer">
                            <button
                                type="button"
                                className="mb__btn mb__btn--ghost"
                                onClick={() =>
                                    (window.location.href =
                                        "/creative-dna/edit")
                                }
                            >
                                Update Creative DNA
                            </button>
                        </div>
                    </>
                )}
            </main>
        </div>
    );
}
