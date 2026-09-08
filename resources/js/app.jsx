/**
 * Entrada React para as páginas que usam o bundle Vite.
 * Monta os componentes React nos pontos de montagem da página.
 */
import React from "react";
import { createRoot } from "react-dom/client";
import Login from "./components/auth/Login";
import Register from "./components/auth/Register";
import ForgotPassword from "./components/auth/ForgotPassword";
import ResetPassword from "./components/auth/ResetPassword";
import CreativeDna from "./components/CreativeDna";
import CreativeDnaView from "./components/CreativeDnaView";
import Projects from "./components/Projects";
import Classes from "./components/Classes";

// Página de Login (React)
const loginRoot = document.getElementById("login-root");
if (loginRoot) {
    createRoot(loginRoot).render(
        <React.StrictMode>
            <Login />
        </React.StrictMode>
    );
}

// Página de Registo (React)
const registerRoot = document.getElementById("register-root");
if (registerRoot) {
    createRoot(registerRoot).render(
        <React.StrictMode>
            <Register />
        </React.StrictMode>
    );
}

// Página "Forgot Password" — recuperação de senha (React)
const forgotPasswordRoot = document.getElementById("forgot-password-root");
if (forgotPasswordRoot) {
    createRoot(forgotPasswordRoot).render(
        <React.StrictMode>
            <ForgotPassword />
        </React.StrictMode>
    );
}

// Página "Reset Password" — definir nova senha via token (React)
const resetPasswordRoot = document.getElementById("reset-password-root");
if (resetPasswordRoot) {
    createRoot(resetPasswordRoot).render(
        <React.StrictMode>
            <ResetPassword
                token={resetPasswordRoot.dataset.token || ""}
                email={resetPasswordRoot.dataset.email || ""}
            />
        </React.StrictMode>
    );
}

// Página Creative DNA inicial para fazer upload de ficheiros (React)
const creativeDnaRoot = document.getElementById("creative-dna-root");
if (creativeDnaRoot) {
    createRoot(creativeDnaRoot).render(
        <React.StrictMode>
            <CreativeDna userName={creativeDnaRoot.dataset.userName || ""} />
        </React.StrictMode>
    );
}

// Pagina Creative DNA de visualização (React)
const creativeDnaViewRoot = document.getElementById("creative-dna-view");
if (creativeDnaViewRoot) {
    createRoot(creativeDnaViewRoot).render(
        <React.StrictMode>
            <CreativeDnaView
                userName={creativeDnaViewRoot.dataset.userName || ""}
            />
        </React.StrictMode>
    );
}

// Página Projects (React)
const projectsRoot = document.getElementById("projects-root");
if (projectsRoot) {
    createRoot(projectsRoot).render(
        <React.StrictMode>
            <Projects
                userName={projectsRoot.dataset.userName || ""}
                isProfessor={projectsRoot.dataset.isProfessor === "1"}
            />
        </React.StrictMode>
    );
}

// Página Classes (professor) — turmas e projetos dos alunos (React)
const classesRoot = document.getElementById("classes-root");
if (classesRoot) {
    createRoot(classesRoot).render(
        <React.StrictMode>
            <Classes userName={classesRoot.dataset.userName || ""} />
        </React.StrictMode>
    );
}
