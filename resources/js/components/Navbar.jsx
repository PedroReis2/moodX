import React from "react";
import axios from "axios";

/**
 * Navbar partilhada por todas as páginas da app.
 * Os links fixos (Creative DNA, My Projects, Logout) vivem aqui.
 * `page` diz à Navbar qual é a página atual, para não se mostrar a si própria.
 * `actions` são botões extra, específicos da página (ex: "New Project").
 */
export default function Navbar({ userName = "", page = "", actions = [] }) {
    const firstName = (userName || "").trim().split(" ")[0] || "";

    const logout = async () => {
        try {
            await axios.post("/logout");
        } finally {
            window.location.href = "/login";
        }
    };

    const fixedLinks = [
        {
            key: "creative-dna",
            label: "My Creative DNA",
            href: "/creative-dna-view",
        },
        { key: "projects", label: "My Projects", href: "/projects" },
    ].filter((link) => link.key !== page);

    return (
        <nav className="app-nav">
            <span className="app-nav__brand">mood.x</span>
            <div className="app-nav__right">
                {firstName && (
                    <span className="app-nav__welcome">
                        Welcome, {firstName}
                    </span>
                )}
                <div className="app-nav__actions">
                    {fixedLinks.map((link) => (
                        <button
                            key={link.key}
                            type="button"
                            className="app-nav__btn app-nav__btn--ghost"
                            onClick={() => (window.location.href = link.href)}
                        >
                            {link.label}
                        </button>
                    ))}

                    {actions.map((action, i) => (
                        <button
                            key={`${action.label}-${i}`}
                            type="button"
                            className={`app-nav__btn ${
                                action.variant === "solid"
                                    ? "app-nav__btn--solid"
                                    : "app-nav__btn--ghost"
                            }`}
                            onClick={action.onClick}
                            disabled={action.disabled}
                        >
                            {action.label}
                        </button>
                    ))}

                    <button
                        type="button"
                        className="app-nav__btn app-nav__btn--ghost"
                        onClick={logout}
                    >
                        Logout
                    </button>
                </div>
            </div>
        </nav>
    );
}
