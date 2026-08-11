import React, { useState } from 'react';
import axios from 'axios';

export default function Login() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [errors, setErrors] = useState([]);
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors([]);
        setLoading(true);

        try {
            await axios.post('/login', { email, password });
            // A raiz decide o destino: Moodboard (se já usou Creative DNA) ou Creative DNA
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
                <div className="login-split__logo-text">mood.x</div>
                <div className="login-split__brand-copy">
                    <p className="login-split__eyebrow">Creative Studio</p>
                </div>
            </aside>

            <main className="login-split__panel">
                <div className="login-split__form-wrap">
                    <h2 className="login-split__title">Welcome</h2>
                    <p className="login-split__subtitle">Sign in to your account.</p>

                    {errors.length > 0 && (
                        <div className="login-split__alert login-split__alert--error">
                            <ul>
                                {errors.map((error, i) => (
                                    <li key={i}>{error}</li>
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
                            <input
                                type="password"
                                className="login-split__input"
                                id="password"
                                placeholder="Enter your password"
                                name="password"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                                required
                            />
                        </div>

                        <div className="login-split__actions">
                            <button type="submit" className="login-split__submit" disabled={loading}>
                                {loading ? 'Signing in...' : 'Sign in'}
                            </button>
                            <a href="/forgot-password" className="login-split__forgot">
                                Forgot password?
                            </a>
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

