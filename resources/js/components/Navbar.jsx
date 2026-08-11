import React from 'react';

/**
 * Navbar partilhada pelas páginas da app (Creative DNA, Moodboard, ...).
 * Preta, com texto branco e botões com efeito de hover.
 * As ações são passadas por props: [{ label, variant: 'solid'|'ghost', onClick, disabled }]
 */
export default function Navbar({ actions = [] }) {
    return (
        <nav className="app-nav">
            <span className="app-nav__brand">mood.x</span>
            <div className="app-nav__actions">
                {actions.map((action, i) => (
                    <button
                        key={`${action.label}-${i}`}
                        type="button"
                        className={`app-nav__btn ${action.variant === 'solid' ? 'app-nav__btn--solid' : 'app-nav__btn--ghost'}`}
                        onClick={action.onClick}
                        disabled={action.disabled}
                    >
                        {action.label}
                    </button>
                ))}
            </div>
        </nav>
    );
}
