import React, { useEffect, useState } from "react";
import axios from "axios";

export default function AdminDashboard({ userName }) {
    const [roles, setRoles] = useState([]);
    const [turmas, setTurmas] = useState([]);
    const [formadores, setFormadores] = useState([]);
    const [alunos, setAlunos] = useState([]);
    const [loading, setLoading] = useState(true);

    // Carrega os dados enviados pelo Laravel para o dashboard admin.
    async function loadAdminData() {
        try {
            const { data } = await axios.get("/admin/data");

            setRoles(data.roles);
            setTurmas(data.turmas);
            setFormadores(data.formadores);
            setAlunos(data.alunos);
        } finally {
            setLoading(false);
        }
    }

    useEffect(() => {
        loadAdminData();
    }, []);

    if (loading) {
        return <p>Loading admin dashboard...</p>;
    }

    return (
        <main className="admin-dashboard">
            <header className="admin-dashboard__header">
                <div>
                    <p className="admin-dashboard__eyebrow">Admin Dashboard</p>
                    <h1>Users and classes</h1>
                </div>

                <p className="admin-dashboard__user">{userName}</p>
            </header>

            <section className="admin-dashboard__section">
                <h2>Students</h2>

                {alunos.map((aluno) => (
                    <article key={aluno.id} className="admin-dashboard__row">
                        <div>
                            <strong>{aluno.name}</strong>
                            <span>{aluno.email}</span>
                        </div>

                        <span>{aluno.turma?.name || "No class assigned"}</span>
                    </article>
                ))}
            </section>

            <section className="admin-dashboard__section">
                <h2>Trainers</h2>

                {formadores.map((formador) => (
                    <article key={formador.id} className="admin-dashboard__row">
                        <div>
                            <strong>{formador.name}</strong>
                            <span>{formador.email}</span>
                        </div>

                        <span>
                            {formador.turmas_como_formador?.length || 0} classes
                        </span>
                    </article>
                ))}
            </section>
        </main>
    );
}
