import React, { useState } from 'react';
import axios from 'axios';

const CheckIcon = () => (
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" strokeWidth="2" aria-hidden="true">
        <path d="M20 6L9 17l-5-5" />
    </svg>
);

/**
 * Página "Forgot Password" em React — layout moderno (split-screen)
 * igual ao Login/Registo. Envia o email para a rota POST /forgot-password
 * (forgot-password.submit) e mostra uma mensagem de confirmação.
 */
export default function ForgotPassword() {
    const [email, setEmail] = useState('');
    const [errors, setErrors] = useState([]);
    const [successMessage, setSuccessMessage] = useState('');
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors([]);
        setSuccessMessage('');
        setLoading(true);

        try {
            const { data } = await axios.post('/forgot-password', { email });
            setSuccessMessage(
                data.message || 'If that email is registered, a recovery link has been sent.'
            );
            setEmail('');
        } catch (err) {
            const data = err.response?.data;
            const msgs = Object.values(data?.errors ?? {}).flat();
            setErrors(msgs.length ? msgs : [data?.message || 'Something went wrong. Please try again.']);
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="login-split forgot-split">
            <aside className="login-split__brand">
                <div className="login-split__logo">mood.x</div>
                <div className="login-split__copy">
                    <p className="login-split__eyebrow">Creative Studio</p>
                    <h1 className="login-split__headline">
                        We&apos;ll get
                        <br />
                        you back <span className="login-split__accent">in.</span>
                    </h1>
                </div>
                <p className="login-split__foot">Your creative DNA, projects &amp; AI.</p>
            </aside>

            <main className="login-split__panel">
                <div className="login-split__form">
                    <p className="login-split__kicker">MOOD.X — Creative Studio</p>
                    <h2 className="login-split__title">Forgot password?</h2>
                    <p className="login-split__subtitle">
                        No worries — enter your email and we&apos;ll send you a link to reset it.
                    </p>

                    {successMessage && (
                        <div className="login-split__alert login-split__alert-success" role="status">
                            <span className="login-split__alert-success-icon">
                                <CheckIcon />
                            </span>
                            {successMessage}
                        </div>
                    )}

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
                                autoComplete="email"
                                required
                                autoFocus
                            />
                        </div>

                        <div className="login-split__actions">
                            <button type="submit" className="login-split__submit" disabled={loading}>
                                {loading ? (
                                    <>
                                        <span className="login-split__spinner" aria-hidden="true" />
                                        Sending...
                                    </>
                                ) : (
                                    'Send reset link'
                                )}
                            </button>
                        </div>
                    </form>

                    <div className="login-split__register">
                        <p className="login-split__register-text">Remembered your password?</p>
                        <a href="/login" className="login-split__register-link">
                            Back to sign in
                        </a>
                    </div>
                </div>
            </main>
        </div>
    );
}
