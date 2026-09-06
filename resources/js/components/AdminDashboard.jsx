import React, { useEffect, useState } from "react";
import axios from "axios";
import Navbar from "./Navbar";

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
        return (
            <div className="mb">
                <Navbar userName={userName} logoutOnly />
                <main className="mb__main">
                    <p className="mb__loading">Loading admin dashboard...</p>
                </main>
            </div>
        );
    }

    return (
        <div className="mb">
            <Navbar userName={userName} logoutOnly />
            <main className="mb__main">
                <header className="mb__header">
                    <p className="mb__kicker">MOOD.X - Admin</p>
                    <h1 className="mb__title">Users and classes</h1>
                    <p className="mb__subtitle">
                        Manage students, teachers, roles and class assignments.
                    </p>
                    <p className="mb__card-count">{userName}</p>
                </header>

                {message && <p className="mb__loading">{message}</p>}

                <div className="cls__list admin-dashboard">
                    <section className="cls__card">
                        <header className="cls__card-head">
                            <h2 className="cls__card-name">Teachers</h2>
                            <span className="cls__card-count">
                                {formadores.length} users
                            </span>
                        </header>

                        <div className="cls__grid admin-dashboard__teacher-grid">
                            {formadores.map((formador) => (
                                <article
                                    key={formador.id}
                                    className="cls__project admin-dashboard__user-card"
                                >
                                    <div className="cls__project-body">
                                        <h3 className="cls__project-title">
                                            {formador.name}
                                        </h3>
                                        <p className="cls__project-student">
                                            {formador.email}
                                        </p>

                                        <div className="admin-dashboard__field-group">
                                            {/* Select para alterar o role do formador. */}
                                            <select
                                                className="admin-dashboard__select"
                                                value={
                                                    teacherRoleDrafts[
                                                        formador.id
                                                    ] || formador.role_id
                                                }
                                                onChange={(event) =>
                                                    updateTeacherRoleDraft(
                                                        formador.id,
                                                        event.target.value,
                                                    )
                                                }
                                            >
                                                {roles.map((role) => (
                                                    <option
                                                        key={role.id}
                                                        value={role.id}
                                                    >
                                                        {role.name}
                                                    </option>
                                                ))}
                                            </select>
                                        </div>

                                        {/* Checkboxes para escolher as turmas atribuídas ao professor. */}
                                        <div className="admin-dashboard__class-list">
                                            {turmas.length === 0 ? (
                                                <p className="admin-dashboard__empty-note">
                                                    No classes available yet.
                                                </p>
                                            ) : (
                                                turmas.map((turma) => (
                                                    <label
                                                        key={turma.id}
                                                        className="admin-dashboard__checkbox"
                                                    >
                                                        <input
                                                            type="checkbox"
                                                            checked={
                                                                teacherDrafts[
                                                                    formador.id
                                                                ]?.includes(
                                                                    turma.id,
                                                                ) || false
                                                            }
                                                            onChange={() =>
                                                                toggleTeacherTurma(
                                                                    formador.id,
                                                                    turma.id,
                                                                )
                                                            }
                                                        />
                                                        <span>
                                                            {turma.name}
                                                        </span>
                                                    </label>
                                                ))
                                            )}
                                        </div>

                                        <button
                                            type="button"
                                            className="mb__btn mb__btn--solid"
                                            onClick={() =>
                                                saveTeacher(formador.id)
                                            }
                                            disabled={
                                                savingTeacherId === formador.id
                                            }
                                        >
                                            {savingTeacherId === formador.id
                                                ? "Saving..."
                                                : "Save"}
                                        </button>
                                    </div>
                                </article>
                            ))}
                        </div>
                    </section>

                    <section className="cls__card">
                        <header className="cls__card-head">
                            <h2 className="cls__card-name">Students</h2>
                            <span className="cls__card-count">
                                {alunos.length} users
                            </span>
                        </header>

                        <div className="cls__grid admin-dashboard__student-grid">
                            {alunos.map((aluno) => (
                                <article
                                    key={aluno.id}
                                    className="cls__project admin-dashboard__user-card"
                                >
                                    <div className="cls__project-body">
                                        <h3 className="cls__project-title">
                                            {aluno.name}
                                        </h3>
                                        <p className="cls__project-student">
                                            {aluno.email}
                                        </p>

                                        <div className="admin-dashboard__student-controls">
                                            {/* Select para alterar o role do utilizador. */}
                                            <select
                                                className="admin-dashboard__select"
                                                value={
                                                    studentDrafts[aluno.id]
                                                        ?.role_id ||
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
                                                    <option
                                                        key={role.id}
                                                        value={role.id}
                                                    >
                                                        {role.name}
                                                    </option>
                                                ))}
                                            </select>

                                            {/* Select para colocar o aluno numa turma. */}
                                            <select
                                                className="admin-dashboard__select admin-dashboard__select--wide"
                                                value={
                                                    studentDrafts[aluno.id]
                                                        ?.turma_id || ""
                                                }
                                                onChange={(event) =>
                                                    updateStudentDraft(
                                                        aluno.id,
                                                        "turma_id",
                                                        event.target.value,
                                                    )
                                                }
                                            >
                                                <option value="">
                                                    No class assigned
                                                </option>

                                                {turmas.map((turma) => (
                                                    <option
                                                        key={turma.id}
                                                        value={turma.id}
                                                    >
                                                        {turma.name}
                                                    </option>
                                                ))}
                                            </select>
                                        </div>

                                        <button
                                            type="button"
                                            className="mb__btn mb__btn--solid"
                                            onClick={() => saveStudent(aluno.id)}
                                            disabled={savingUserId === aluno.id}
                                        >
                                            {savingUserId === aluno.id
                                                ? "Saving..."
                                                : "Save"}
                                        </button>
                                    </div>
                                </article>
                            ))}
                        </div>
                    </section>
                </div>
            </main>
        </div>
    );
}
