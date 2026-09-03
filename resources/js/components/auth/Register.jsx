import React, { useState } from 'react';
import axios from 'axios';

const EyeIcon = () => (
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" strokeWidth="1.8" aria-hidden="true">
        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z" />
        <circle cx="12" cy="12" r="3" />
    </svg>
);

const EyeOffIcon = () => (
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" strokeWidth="1.8" aria-hidden="true">
        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19M14.12 14.12A3 3 0 1 1 9.88 9.88" />
        <line x1="1" y1="1" x2="23" y2="23" />
    </svg>
);

/**
 * Página de Registo em React — layout moderno (split-screen) igual ao Login.
 * Faz POST para a rota /store_user e trata erros de validação.
 */
export default function Register() {
    const [form, setForm] = useState({
        first_name: '',
        last_name: '',
        username: '',
        email: '',
        password: '',
        password_confirmation: '',
    });
    const [showPassword, setShowPassword] = useState(false);
    const [showConfirm, setShowConfirm] = useState(false);
    const [errors, setErrors] = useState([]);
    const [loading, setLoading] = useState(false);

    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors([]);
        setLoading(true);

        try {
            // O backend cria a conta e responde com redirect (302) para /dashboard.
            // No browser, o XHR segue o redirect; como o utilizador não é autenticado
            // automaticamente, o /dashboard (protegido) responde 401.
            // Ambos os casos significam "conta criada com sucesso".
            await axios.post('/store_user', form);

            // Se chegámos aqui sem exceção -> conta criada
            window.location.href = '/login';
        } catch (err) {
            // 401 = conta criada mas o redirect para /dashboard falhou (não autenticado)
            if (err.response && err.response.status === 401) {
                window.location.href = '/login';
                return;
            }

            setLoading(false);

            if (err.response && err.response.status === 422) {
                const validationErrors = err.response.data.errors;
                const flat = Object.values(validationErrors || {}).flat();
                setErrors(flat.length ? flat : ['Unable to create account. Please check your details.']);
            } else if (err.response && err.response.data && err.response.data.message) {
                setErrors([err.response.data.message]);
            } else {
                setErrors(['Something went wrong. Please try again.']);
            }
        }
    };

    return (
        <div className="login-split register-split">
            <aside className="login-split__brand">
                <div className="login-split__logo">mood.x</div>
                <div className="login-split__copy">
                    <p className="login-split__eyebrow">Creative Studio</p>
                    <h1 className="login-split__headline">
                        Start your
                        <br />
                        creative <span className="login-split__accent">story.</span>
                    </h1>
                </div>
                <p className="login-split__foot">Your creative DNA, projects &amp; AI.</p>
            </aside>

            <main className="login-split__panel">
                <div className="login-split__form">
                    <p className="login-split__kicker">MOOD.X — Creative Studio</p>
                    <h2 className="login-split__title">Create account</h2>
                    <p className="login-split__subtitle">Tell us a little about yourself to get started.</p>

                    {errors.length > 0 && (
                        <div className="login-split__alert login-split__alert-error" role="alert">
                            <ul>
                                {errors.map((error, i) => (
                                    <li key={i}>
                                        <span className="login-split__alert-icon">!</span>
                                        {error}
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}

                    <form onSubmit={handleSubmit} noValidate>
                        <div className="register-split__grid">
                            <div className="login-split__field">
                                <label className="login-split__label" htmlFor="first_name">First name</label>
                                <input
                                    type="text"
                                    className="login-split__input"
                                    id="first_name"
                                    name="first_name"
                                    placeholder="Jane"
                                    value={form.first_name}
                                    onChange={handleChange}
                                    autoComplete="given-name"
                                    required
                                    autoFocus
                                />
                            </div>

                            <div className="login-split__field">
                                <label className="login-split__label" htmlFor="last_name">Last name</label>
                                <input
                                    type="text"
                                    className="login-split__input"
                                    id="last_name"
                                    name="last_name"
                                    placeholder="Doe"
                                    value={form.last_name}
                                    onChange={handleChange}
                                    autoComplete="family-name"
                                    required
                                />
                            </div>
                        </div>

                        <div className="login-split__field">
                            <label className="login-split__label" htmlFor="username">Username</label>
                            <input
                                type="text"
                                className="login-split__input"
                                id="username"
                                name="username"
                                placeholder="janedoe"
                                value={form.username}
                                onChange={handleChange}
                                autoComplete="username"
                                required
                            />
                        </div>

                        <div className="login-split__field">
                            <label className="login-split__label" htmlFor="email">Email</label>
                            <input
                                type="email"
                                className="login-split__input"
                                id="email"
                                name="email"
                                placeholder="you@example.com"
                                value={form.email}
                                onChange={handleChange}
                                autoComplete="email"
                                required
                            />
                        </div>

                        <div className="register-split__grid">
                            <div className="login-split__field">
                                <label className="login-split__label" htmlFor="password">Password</label>
                                <div className="login-split__input-wrap">
                                    <input
                                        type={showPassword ? 'text' : 'password'}
                                        className="login-split__input login-split__input-password"
                                        id="password"
                                        name="password"
                                        placeholder="Min. 6 characters"
                                        value={form.password}
                                        onChange={handleChange}
                                        autoComplete="new-password"
                                        required
                                    />
                                    <button
                                        type="button"
                                        className="login-split__toggle"
                                        onClick={() => setShowPassword((v) => !v)}
                                        aria-label={showPassword ? 'Hide password' : 'Show password'}
                                    >
                                        {showPassword ? <EyeOffIcon /> : <EyeIcon />}
                                    </button>
                                </div>
                            </div>

                            <div className="login-split__field">
                                <label className="login-split__label" htmlFor="password_confirmation">Confirm</label>
                                <div className="login-split__input-wrap">
                                    <input
                                        type={showConfirm ? 'text' : 'password'}
                                        className="login-split__input login-split__input-password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        placeholder="Repeat password"
                                        value={form.password_confirmation}
                                        onChange={handleChange}
                                        autoComplete="new-password"
                                        required
                                    />
                                    <button
                                        type="button"
                                        className="login-split__toggle"
                                        onClick={() => setShowConfirm((v) => !v)}
                                        aria-label={showConfirm ? 'Hide password' : 'Show password'}
                                    >
                                        {showConfirm ? <EyeOffIcon /> : <EyeIcon />}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div className="login-split__actions">
                            <button type="submit" className="login-split__submit" disabled={loading}>
                                {loading ? (
                                    <>
                                        <span className="login-split__spinner" aria-hidden="true" />
                                        Creating...
                                    </>
                                ) : (
                                    'Create account'
                                )}
                            </button>
                        </div>
                    </form>

                    <div className="login-split__register">
                        <p className="login-split__register-text">Already have an account?</p>
                        <a href="/login" className="login-split__register-link">
                            Sign in
                        </a>
                    </div>
                </div>
            </main>
        </div>
    );
}
