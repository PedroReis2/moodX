import React from "react";
import Navbar from "./Navbar";

/**
 * Página "Classes" (apenas professor).
 *
 * NOTA: os dados abaixo são MOCK apenas para validar o design.
 * Quando o backend estiver pronto, substituir MOCK_CLASSES pela resposta de
 * um endpoint (ex.: GET /classes), com a forma:
 *   [{ id, name, projects: [{ id, title, student, date, imageCount, palette }] }]
 */

const MOCK_CLASSES = [
    {
        id: 1,
        name: "Fashion Production",
        projects: [
            {
                id: 101,
                title: "Urban Linen Collection",
                student: "Ana Martins",
                date: "2026-08-20",
                imageCount: 5,
                palette: ["#e8dcc3", "#232323", "#a33c3c"],
            },
            {
                id: 102,
                title: "Spring Moodboard",
                student: "Beatriz Lopes",
                date: "2026-08-25",
                imageCount: 4,
                palette: ["#d9e2c3", "#3c5a3c", "#f0e2cf"],
            },
            {
                id: 103,
                title: "Fabrics & Textures",
                student: "Carlos Mendes",
                date: "2026-09-01",
                imageCount: 5,
                palette: ["#2b2b2b", "#c9b99a", "#7a4a2a"],
            },
        ],
    },
    {
        id: 2,
        name: "Arts and Graphic Technologies",
        projects: [
            {
                id: 201,
                title: "Mood.X Visual Identity",
                student: "Diana Reis",
                date: "2026-08-18",
                imageCount: 4,
                palette: ["#141414", "#f5f0e6", "#c8a24a"],
            },
            {
                id: 202,
                title: "Digital Fashion Poster",
                student: "Eduardo Sousa",
                date: "2026-08-27",
                imageCount: 5,
                palette: ["#6a1f9c", "#e4e0ec", "#1c1c1c"],
            },
        ],
    },
    {
        id: 3,
        name: "Dressmaking",
        projects: [
            {
                id: 301,
                title: "Structured Midi Dress",
                student: "Filipa Costa",
                date: "2026-08-22",
                imageCount: 5,
                palette: ["#efe4d8", "#b07a52", "#333333"],
            },
            {
                id: 302,
                title: "Draping Sample",
                student: "Gonçalo Pinto",
                date: "2026-08-30",
                imageCount: 4,
                palette: ["#c9d5dd", "#2c3e50", "#ffffff"],
            },
            {
                id: 303,
                title: "Finishing & Stitching",
                student: "Helena Rocha",
                date: "2026-09-03",
                imageCount: 5,
                palette: ["#dcdcdc", "#8c8c8c", "#202020"],
            },
        ],
    },
    {
        id: 4,
        name: "Tailoring",
        projects: [
            {
                id: 401,
                title: "Classic Blazer",
                student: "Inês Ferreira",
                date: "2026-08-21",
                imageCount: 5,
                palette: ["#3b3b46", "#b9b4a8", "#e6e0d2"],
            },
            {
                id: 402,
                title: "Tailored Jeans",
                student: "João Pereira",
                date: "2026-08-28",
                imageCount: 4,
                palette: ["#4a6fa5", "#cfd8e3", "#1f2937"],
            },
        ],
    },
    {
        id: 5,
        name: "Fashion Accessories",
        projects: [
            {
                id: 501,
                title: "Vegan Leather Bags",
                student: "Leonor Alves",
                date: "2026-08-24",
                imageCount: 5,
                palette: ["#8a5a3a", "#e0d3c0", "#26221e"],
            },
            {
                id: 502,
                title: "Organic Jewellery",
                student: "Mariana Cunha",
                date: "2026-08-31",
                imageCount: 4,
                palette: ["#d8c98a", "#6f6f6f", "#f7f3e7"],
            },
            {
                id: 503,
                title: "Travel Luggage",
                student: "Nuno Tavares",
                date: "2026-09-04",
                imageCount: 5,
                palette: ["#293241", "#c1b49c", "#a53f3f"],
            },
        ],
    },
];

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

export default function Classes({ userName = "" }) {
    const classes = MOCK_CLASSES;

    return (
        <div className="mb">
            <Navbar userName={userName} page="classes" />

            <main className="mb__main">
                <header className="mb__header">
                    <p className="mb__kicker">MOOD.X — Creative Studio</p>
                    <h1 className="mb__title">Classes</h1>
                    <p className="mb__subtitle">
                        The classes you teach and the projects your students
                        created.
                    </p>
                </header>

                <div className="cls__list">
                    {classes.map((cls) => (
                        <section key={cls.id} className="cls__card">
                            <header className="cls__card-head">
                                <h2 className="cls__card-name">{cls.name}</h2>
                                <span className="cls__card-count">
                                    {cls.projects.length}{" "}
                                    {cls.projects.length === 1
                                        ? "project"
                                        : "projects"}
                                </span>
                            </header>

                            <div className="cls__grid">
                                {cls.projects.map((p) => (
                                    <article
                                        key={p.id}
                                        className="cls__project"
                                    >
                                        <div
                                            className="cls__project-cover"
                                            style={
                                                p.palette &&
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
                                            <span className="cls__project-monogram">
                                                {p.title
                                                    .trim()
                                                    .charAt(0)
                                                    .toUpperCase()}
                                            </span>
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
                                                                    key={hex}
                                                                    className="cls__palette-swatch"
                                                                    style={{
                                                                        backgroundColor:
                                                                            hex,
                                                                    }}
                                                                    title={hex}
                                                                />
                                                            )
                                                        )}
                                                    </div>
                                                )}
                                        </div>
                                    </article>
                                ))}
                            </div>
                        </section>
                    ))}
                </div>
            </main>
        </div>
    );
}
