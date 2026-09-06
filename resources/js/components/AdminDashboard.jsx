import React, { useEffect, useState } from "react";
import axios from "axios";

export default function AdminDashboard({ userName }) {
    const [roles, setRoles] = useState([]);
    const [turmas, setTurmas] = useState([]);
    const [formadores, setFormadores] = useState([]);
    const [alunos, setAlunos] = useState([]);
    const [loading, setLoading] = useState(true);
    const [studentDrafts, setStudentDrafts] = useState({});
    const [savingUserId, setSavingUserId] = useState(null);
    const [message, setMessage] = useState("");
    const [teacherDrafts, setTeacherDrafts] = useState({});
    const [savingTeacherId, setSavingTeacherId] = useState(null);
    const [teacherRoleDrafts, setTeacherRoleDrafts] = useState({});

    // Carrega os dados enviados pelo Laravel para o dashboard admin.
    async function loadAdminData() {
        try {
            const { data } = await axios.get("/admin/data");

            setRoles(data.roles);
            setTurmas(data.turmas);
            setFormadores(data.formadores);
            setAlunos(data.alunos);
            // Guarda os valores atuais de cada aluno para serem editados nos selects.
            setStudentDrafts(
                Object.fromEntries(
                    data.alunos.map((aluno) => [
                        aluno.id,
                        {
                            role_id: aluno.role_id,
                            turma_id: aluno.turma_id || "",
                        },
                    ]),
                ),
            );
            // Guarda as turmas atuais de cada formador para serem editadas.
            setTeacherDrafts(
                Object.fromEntries(
                    data.formadores.map((formador) => [
                        formador.id,
                        formador.turmas_como_formador?.map(
                            (turma) => turma.id,
                        ) || [],
                    ]),
                ),
            );
            // Guarda o role atual de cada formador para poder ser alterado.
            setTeacherRoleDrafts(
                Object.fromEntries(
                    data.formadores.map((formador) => [
                        formador.id,
                        formador.role_id,
                    ]),
                ),
            );
        } finally {
            setLoading(false);
        }
    }
    // Atualiza temporariamente os dados do aluno antes de guardar.
    function updateStudentDraft(alunoId, field, value) {
        setStudentDrafts((currentDrafts) => ({
            ...currentDrafts,
            [alunoId]: {
                ...currentDrafts[alunoId],
                [field]: value,
            },
        }));
    }

    // Guarda no backend o role e a turma escolhidos para o aluno.
    async function saveStudent(alunoId) {
        const draft = studentDrafts[alunoId];

        setSavingUserId(alunoId);
        setMessage("");

        try {
            await axios.put(`/admin/users/${alunoId}`, {
                role_id: Number(draft.role_id),
                turma_id: draft.turma_id ? Number(draft.turma_id) : null,
            });

            setMessage("Student updated successfully.");

            // Recarrega os dados para garantir que a página mostra a informação atualizada.
            await loadAdminData();
        } catch (error) {
            setMessage(
                error.response?.data?.message || "Unable to update student.",
            );
        } finally {
            setSavingUserId(null);
        }
    }
    // Adiciona ou remove uma turma da lista temporária do formador.
    function toggleTeacherTurma(formadorId, turmaId) {
        setTeacherDrafts((currentDrafts) => {
            const currentTurmas = currentDrafts[formadorId] || [];

            const updatedTurmas = currentTurmas.includes(turmaId)
                ? currentTurmas.filter((id) => id !== turmaId)
                : [...currentTurmas, turmaId];

            return {
                ...currentDrafts,
                [formadorId]: updatedTurmas,
            };
        });
    }

    // Guarda no backend o role e as turmas escolhidas para o formador.
    async function saveTeacher(formadorId) {
        const selectedRoleId = Number(teacherRoleDrafts[formadorId]);

        setSavingTeacherId(formadorId);
        setMessage("");

        try {
            // Primeiro atualiza o role do utilizador.
            await axios.put(`/admin/users/${formadorId}`, {
                role_id: selectedRoleId,
                turma_id: null,
            });

            // Se continuar a ser formador, atualiza também as turmas dele.
            if (selectedRoleId === 2) {
                await axios.put(`/admin/formadores/${formadorId}/turmas`, {
                    turma_ids: teacherDrafts[formadorId] || [],
                });
            }

            setMessage("Teacher updated successfully.");

            // Recarrega os dados para atualizar as listas.
            await loadAdminData();
        } catch (error) {
            setMessage(
                error.response?.data?.message || "Unable to update teacher.",
            );
        } finally {
            setSavingTeacherId(null);
        }
    }

    // Atualiza temporariamente o role escolhido para o formador.
    function updateTeacherRoleDraft(formadorId, value) {
        setTeacherRoleDrafts((currentDrafts) => ({
            ...currentDrafts,
            [formadorId]: value,
        }));
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
            {message && <p className="admin-dashboard__message">{message}</p>}

            <section className="admin-dashboard__section">
                <h2>Students</h2>

                {alunos.map((aluno) => (
                    <article key={aluno.id} className="admin-dashboard__row">
                        <div>
                            <strong>{aluno.name}</strong>
                            <span>{aluno.email}</span>
                        </div>
                        <div className="admin-dashboard__actions">
                            {/* Select para alterar o role do utilizador. */}
                            <select
                                value={
                                    studentDrafts[aluno.id]?.role_id ||
                                    aluno.role_id
                                }
                                onChange={(event) =>
                                    updateStudentDraft(
                                        aluno.id,
                                        "role_id",
                                        event.target.value,
                                    )
                                }
                            >
                                {roles.map((role) => (
                                    <option key={role.id} value={role.id}>
                                        {role.name}
                                    </option>
                                ))}
                            </select>

                            {/* Select para colocar o aluno numa turma. */}
                            <select
                                value={studentDrafts[aluno.id]?.turma_id || ""}
                                onChange={(event) =>
                                    updateStudentDraft(
                                        aluno.id,
                                        "turma_id",
                                        event.target.value,
                                    )
                                }
                            >
                                <option value="">No class assigned</option>

                                {turmas.map((turma) => (
                                    <option key={turma.id} value={turma.id}>
                                        {turma.name}
                                    </option>
                                ))}
                            </select>

                            <button
                                type="button"
                                onClick={() => saveStudent(aluno.id)}
                                disabled={savingUserId === aluno.id}
                            >
                                {savingUserId === aluno.id
                                    ? "Saving..."
                                    : "Save"}
                            </button>
                        </div>{" "}
                    </article>
                ))}
            </section>

            <section className="admin-dashboard__section">
                <h2>Teachers</h2>

                {formadores.map((formador) => (
                    <article key={formador.id} className="admin-dashboard__row">
                        <div>
                            <strong>{formador.name}</strong>
                            <span>{formador.email}</span>
                        </div>

                        <div className="admin-dashboard__actions">
                            {/* Select para alterar o role do formador. */}
                            <select
                                value={
                                    teacherRoleDrafts[formador.id] ||
                                    formador.role_id
                                }
                                onChange={(event) =>
                                    updateTeacherRoleDraft(
                                        formador.id,
                                        event.target.value,
                                    )
                                }
                            >
                                {roles.map((role) => (
                                    <option key={role.id} value={role.id}>
                                        {role.name}
                                    </option>
                                ))}
                            </select>

                            {/* Checkboxes para escolher as turmas atribuídas ao formador. */}
                            <div className="admin-dashboard__checkboxes">
                                {turmas.map((turma) => (
                                    <label key={turma.id}>
                                        <input
                                            type="checkbox"
                                            checked={
                                                teacherDrafts[
                                                    formador.id
                                                ]?.includes(turma.id) || false
                                            }
                                            onChange={() =>
                                                toggleTeacherTurma(
                                                    formador.id,
                                                    turma.id,
                                                )
                                            }
                                        />
                                        {turma.name}
                                    </label>
                                ))}
                            </div>

                            <button
                                type="button"
                                onClick={() => saveTeacher(formador.id)}
                                disabled={savingTeacherId === formador.id}
                            >
                                {savingTeacherId === formador.id
                                    ? "Saving..."
                                    : "Save"}
                            </button>
                        </div>
                    </article>
                ))}
            </section>
        </main>
    );
}
