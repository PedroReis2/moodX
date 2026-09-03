import React, { useEffect, useState } from "react";
import axios from "axios";
import Navbar from "./Navbar";

export default function CreativeDnaView({ userName = "" }) {
    const [images, setImages] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios
            .get("/creative-dna/data")
            .then(({ data }) => setImages(data.images))
            .finally(() => setLoading(false));
    }, []);

    const logout = async () => {
        try {
            await axios.post("/logout");
        } finally {
            window.location.href = "/login";
        }
    };

    return (
        <div className="mb">
            <Navbar
                userName={userName}
                actions={[
                    {
                        label: "My Projects",
                        onClick: () => (window.location.href = "/projects"),
                        variant: "ghost",
                    },
                    { label: "Logout", onClick: logout, variant: "ghost" },
                ]}
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
                    <div className="mb__grid">
                        {images.map((img) => (
                            <article key={img.id} className="mb__card">
                                <img
                                    className="mb__card-cover"
                                    src={img.url}
                                    alt="Creative DNA reference"
                                />
                                {img.colors?.length > 0 && (
                                    <div className="mb__palette">
                                        {img.colors.map((color) => (
                                            <span
                                                key={`${img.id}-${color.hex}`}
                                                className="mb__palette-swatch"
                                                style={{
                                                    backgroundColor: color.hex,
                                                }}
                                                title={color.hex}
                                            />
                                        ))}
                                    </div>
                                )}
                            </article>
                        ))}
                    </div>
                )}
            </main>
        </div>
    );
}
