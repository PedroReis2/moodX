import React, { useState } from 'react';
import axios from 'axios';

/**
 * Página de Login em React (substitui o formulário Blade).
 * Faz POST para a rota Fortify /login e trata erros de validação.
 */
export default function Login() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [errors, setErrors] = useState([]);
    const [message, setMessage] = useState('');
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors([]);
        setMessage('');
        setLoading(true);

        try {
            await axios.post('/login', { email, password });
            // Fortify autenticou com sucesso -> redireciona para o dashboard
            window.location.href = '/dashboard';
        } catch (err) {
            setLoading(false);

            if (err.response && err.response.status === 422) {
                // Erros de validação (email/password incorrectos)
                const validationErrors = err.response.data.errors;
                const flat = Object.values(validationErrors || {}).flat();
                setErrors(flat.length ? flat : ['The provided credentials are incorrect.']);
            } else if (err.response && err.response.data && err.response.data.message) {
                setErrors([err.response.data.message]);
            } else {
                setErrors(['Something went wrong. Please try again.']);
            }
        }
    };

    return (
        <div>
            {message && (
                <div className="alert alert-success">
                    {message}
                </div>
            )}

            {errors.length > 0 && (
                <div className="alert alert-danger">
                    <ul className="mb-0">
                        {errors.map((error, i) => (
                            <li key={i}>{error}</li>
                        ))}
                    </ul>
                </div>
            )}

            <div className="rectangle-header-logo" style={{ position: 'relative' }}>
                <img src="/images/logo.png" alt="Header Logo" className="rectangle-logo" />
                <a href="/" className="close-button" style={{ position: 'absolute', top: '-25px', right: 0, fontSize: 24, color: 'black' }}>
                    <i className="fa-solid fa-xmark"></i>
                </a>
            </div>

            <div className="rectangle-header-slogan">
                <img src="/images/slogan.png" alt="Header Slogan" className="rectangle-slogan" />
            </div>

            <div className="form-container">
                <form onSubmit={handleSubmit}>
                    <div className="form-floating-login mb-1">
                        <input
                            type="email"
                            className="form-control"
                            id="email"
                            placeholder="Email"
                            name="email"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            required
                            autoFocus
                        />
                        <label htmlFor="email"></label>
                    </div>

                    <div className="form-floating-login mb-1">
                        <input
                            type="password"
                            className="form-control"
                            id="password_login"
                            placeholder="Password"
                            name="password"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            required
                        />
                        <label htmlFor="password"></label>
                    </div>

                    <div className="button-container">
                        <button type="submit" className="button button_wide" disabled={loading}>
                            {loading ? 'Loading...' : 'Login'}
                        </button>
                    </div>

                    <div className="forgot-password-container">
                        <a href="/forgot-password" className="change-password-link">
                            Forgot password?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    );
}
