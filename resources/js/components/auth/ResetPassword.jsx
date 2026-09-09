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
 * Página "Reset Password" em React — layout moderno (split-screen)
 * igual ao Login/Registo/Forgot. Recebe o token e o email via props
 * (vindos do link de recuperação) e submete a nova palavra-passe para
 * a rota POST /reset-password (password.update) gerida pelo Fortify.
 */
export default function ResetPassword({ token, email: initialEmail }) {
    const [email] = useState(initialEmail || '');
    const [password, setPassword] = useState('');
    const [passwordConfirmation, setPasswordConfirmation] = useState('');
    const [showPassword, setShowPassword] = useState(false);
    const [showConfirm, setShowConfirm] = useState(false);
    const [errors, setErrors] = useState([]);
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors([]);
        setLoading(true);

        try {
            const { data } = await axios.post('/reset-password', {
                token,
                email,
                password,
                password_confirmation: passwordConfirmation,
            });

            // Sucesso — volta para o login (data.redirect quando o backend define)
            window.location.href = data.redirect || '/login';
        } catch (err) {
            setLoading(false);
            const data = err.response?.data;
            const msgs = Object.values(data?.errors ?? {}).flat();
            setErrors(
                msgs.length
                    ? msgs
                    : [data?.message || 'Something went wrong. Please try again.']
            );
        }
    };

    return (
        <div className="login-split reset-split">
            <aside className="login-split__brand">
                <div className="login-split__logo">mood.x</div>
                <div className="login-split__copy">
                    <p className="login-split__eyebrow">Creative Studio</p>
                    <h1 className="login-split__headline">
                        Set your
                        <br />
                        new <span className="login-split__accent">password.</span>
                    </h1>
                </div>
                <p className="login-split__foot">Your creative DNA, projects &amp; AI.</p>
            </aside>

            <main className="login-split__panel">
                <div className="login-split__form">
                    <p className="login-split__kicker">MOOD.X — Creative Studio</p>
                    <h2 className="login-split__title">Reset password</h2>
                    <p className="login-split__subtitle">
                        Choose a new password for your account.
                    </p>

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
                        <div className="login-split__field">
                            <label className="login-split__label" htmlFor="email">Email</label>
                            <input
                                type="email"
                                className="login-split__input"
                                id="email"
                                name="email"
                                value={email}
                                readOnly
                                tabIndex={-1}
                            />
                        </div>

                        <div className="reset-split__grid">
                            <div className="login-split__field">
                                <label className="login-split__label" htmlFor="password">New password</label>
                                <div className="login-split__input-wrap">
                                    <input
                                        type={showPassword ? 'text' : 'password'}
                                        className="login-split__input login-split__input-password"
                                        id="password"
                                        name="password"
                                        placeholder="At least 8 characters"
                                        value={password}
                                        onChange={(e) => setPassword(e.target.value)}
                                        autoComplete="new-password"
                                        required
                                        autoFocus
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
                                        value={passwordConfirmation}
                                        onChange={(e) => setPasswordConfirmation(e.target.value)}
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
                                        Resetting...
                                    </>
                                ) : (
                                    'Reset password'
                                )}
                            </button>
                        </div>
                    </form>

                    <div className="login-split__register">
                        <p className="login-split__register-text">Remembered it after all?</p>
                        <a href="/login" className="login-split__register-link">
                            Back to sign in
                        </a>
                    </div>
                </div>
            </main>
        </div>
    );
}
