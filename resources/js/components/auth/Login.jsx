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

export default function Login() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [remember, setRemember] = useState(true);
    const [showPassword, setShowPassword] = useState(false);
    const [errors, setErrors] = useState([]);
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors([]);
        setLoading(true);

        try {
            await axios.post('/login', { email, password, remember });
            // A raiz decide o destino: Projects (se já usou Creative DNA) ou Creative DNA
            window.location.href = '/';
        } catch (err) {
            setLoading(false);
            const data = err.response?.data;
            const msgs = Object.values(data?.errors ?? {}).flat();
            setErrors(msgs.length ? msgs : [data?.message || 'Something went wrong. Please try again.']);
        }
    };

    return (
        <div className="login-split">
            <aside className="login-split__brand">
                <div className="login-split__logo">mood.x</div>
                <div className="login-split__copy">
                    <p className="login-split__eyebrow">Creative Studio</p>
                    <h1 className="login-split__headline">
                        Where ideas
                        <br />
                        become <span className="login-split__accent">design.</span>
                    </h1>
                </div>
                <p className="login-split__foot">Your creative DNA, projects &amp; AI.</p>
            </aside>

            <main className="login-split__panel">
                <div className="login-split__form">
                    <p className="login-split__kicker">MOOD.X — Creative Studio</p>
                    <h2 className="login-split__title">Welcome</h2>
                    <p className="login-split__subtitle">Sign in to your account.</p>

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

                    <form onSubmit={handleSubmit}>
                        <div className="login-split__field">
                            <label className="login-split__label" htmlFor="email">Email</label>
                            <input
                                type="email"
                                className="login-split__input"
                                id="email"
                                placeholder="you@example.com"
                                name="email"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                required
                                autoFocus
                            />
                        </div>

                        <div className="login-split__field">
                            <label className="login-split__label" htmlFor="password">Password</label>
                            <div className="login-split__input-wrap">
                                <input
                                    type={showPassword ? 'text' : 'password'}
                                    className="login-split__input login-split__input-password"
                                    id="password"
                                    placeholder="Enter your password"
                                    name="password"
                                    value={password}
                                    onChange={(e) => setPassword(e.target.value)}
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

                        <div className="login-split__remember">
                            <label className="login-split__check">
                                <input
                                    type="checkbox"
                                    checked={remember}
                                    onChange={(e) => setRemember(e.target.checked)}
                                />
                                <span>Remember me</span>
                            </label>
                            <a href="/forgot-password" className="login-split__forgot">
                                Forgot password?
                            </a>
                        </div>

                        <div className="login-split__actions">
                            <button type="submit" className="login-split__submit" disabled={loading}>
                                {loading ? (
                                    <>
                                        <span className="login-split__spinner" aria-hidden="true" />
                                        Signing in...
                                    </>
                                ) : (
                                    'Sign in'
                                )}
                            </button>
                        </div>
                    </form>

                    <div className="login-split__register">
                        <p className="login-split__register-text">Don&apos;t have an account?</p>
                        <a href="/register" className="login-split__register-link">
                            Create an account
                        </a>
                    </div>
                </div>
            </main>
        </div>
    );
}

