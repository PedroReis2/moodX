import React, { useEffect, useState } from "react";
import axios from "axios";
import Navbar from "./Navbar";

export default function AdminDashboard({ userName }) {
    const [roles, setRoles] = useState([]);
    const [turmas, setTurmas] = useState([]);
    const [formadores, setFormadores] = useState([]);
    const [alunos, setAlunos] = useState([]);
    const [newUsers, setNewUsers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [studentDrafts, setStudentDrafts] = useState({});
    const [savingUserId, setSavingUserId] = useState(null);
    const [message, setMessage] = useState("");
    const [teacherDrafts, setTeacherDrafts] = useState({});
    const [savingTeacherId, setSavingTeacherId] = useState(null);
    const [teacherRoleDrafts, setTeacherRoleDrafts] = useState({});
    const [newUserDrafts, setNewUserDrafts] = useState({});
    const [savingNewUserId, setSavingNewUserId] = useState(null);

    // Carrega os dados enviados pelo Laravel para o dashboard admin.
    async function loadAdminData() {
        try {
            const { data } = await axios.get("/admin/data");

            setRoles(data.roles);
            setTurmas(data.turmas);
            setFormadores(data.formadores);
            setAlunos(data.alunos);
            setNewUsers(data.newUsers);
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

            // Guarda os valores das pessoas novas antes do admin decidir a função final.
            setNewUserDrafts(
                Object.fromEntries(
                    data.newUsers.map((user) => [
                        user.id,
                        {
                            role_id: user.role_id,
                            turma_id: user.turma_id || "",
                            turma_ids: [],
                        },
                    ]),
                ),
            );
        } finally {
            setLoading(false);
        }
    }

    // Mostra os nomes das funções de forma mais clara no dashboard.
    function roleLabel(role) {
        const roleName = role.name.toLowerCase();

        if (roleName === "formador") {
            return "teacher";
        }

        if (roleName === "user") {
            return "student";
        }

        return role.name;
    }

    // Encontra o nome real da função escolhida.
    function selectedRoleName(roleId) {
        return (
            roles
                .find((role) => Number(role.id) === Number(roleId))
                ?.name.toLowerCase() || ""
        );
    }

    // Confirma se a função escolhida corresponde a professor.
    function isTeacherRole(roleId) {
        return ["formador", "teacher", "professor"].includes(
            selectedRoleName(roleId),
        );
    }

    // Confirma se a função escolhida corresponde a aluno.
    function isStudentRole(roleId) {
        return ["user", "student", "aluno"].includes(selectedRoleName(roleId));
    }

    // Atualiza temporariamente os dados de uma pessoa nova.
    function updateNewUserDraft(userId, field, value) {
        setNewUserDrafts((currentDrafts) => ({
            ...currentDrafts,
            [userId]: {
                ...currentDrafts[userId],
                [field]: value,
            },
        }));
    }

    // Adiciona ou remove uma turma na classificação de uma pessoa nova como professor.
    function toggleNewUserTurma(userId, turmaId) {
        setNewUserDrafts((currentDrafts) => {
            const currentTurmas = currentDrafts[userId]?.turma_ids || [];

            const updatedTurmas = currentTurmas.includes(turmaId)
                ? currentTurmas.filter((id) => id !== turmaId)
                : [...currentTurmas, turmaId];

            return {
                ...currentDrafts,
                [userId]: {
                    ...currentDrafts[userId],
                    turma_ids: updatedTurmas,
                },
            };
        });
    }

    // Guarda a função escolhida para uma pessoa nova e move-a para o card correto.
    async function saveNewUser(userId) {
        const draft = newUserDrafts[userId];
        const selectedRoleId = Number(draft.role_id);

        setSavingNewUserId(userId);
        setMessage("");

        try {
            await axios.put(`/admin/users/${userId}`, {
                role_id: selectedRoleId,
                turma_id: draft.turma_id ? Number(draft.turma_id) : null,
            });

            // Se a pessoa nova for professor, guarda também as turmas atribuídas.
            if (selectedRoleId === 2) {
                await axios.put(`/admin/formadores/${userId}/turmas`, {
                    turma_ids: draft.turma_ids || [],
                });
            }

            setMessage("New person updated successfully.");

            // Recarrega as listas para a pessoa aparecer no card correto.
            await loadAdminData();
        } catch (error) {
            const errors = error.response?.data?.errors;
            const firstError = errors ? Object.values(errors).flat()[0] : null;

            setMessage(
                firstError ||
                    error.response?.data?.message ||
                    "Unable to update new person.",
            );
        } finally {
            setSavingNewUserId(null);
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
        const selectedRoleId = Number(draft.role_id);

        setSavingUserId(alunoId);
        setMessage("");

        try {
            await axios.put(`/admin/users/${alunoId}`, {
                role_id: selectedRoleId,
                turma_id: isStudentRole(selectedRoleId) && draft.turma_id
                    ? Number(draft.turma_id)
                    : null,
            });

            // Se o aluno passar a professor, guarda também as turmas atribuídas.
            if (isTeacherRole(selectedRoleId)) {
                await axios.put(`/admin/formadores/${alunoId}/turmas`, {
                    turma_ids: teacherDrafts[alunoId] || [],
                });
            }

            setMessage("User updated successfully.");

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
        const studentDraft = studentDrafts[formadorId] || {};

        setSavingTeacherId(formadorId);
        setMessage("");

        try {
            // Primeiro atualiza o role do utilizador.
            await axios.put(`/admin/users/${formadorId}`, {
                role_id: selectedRoleId,
                turma_id: isStudentRole(selectedRoleId) && studentDraft.turma_id
                    ? Number(studentDraft.turma_id)
                    : null,
            });

            // Se continuar a ser formador, atualiza também as turmas dele.
            if (isTeacherRole(selectedRoleId)) {
                await axios.put(`/admin/formadores/${formadorId}/turmas`, {
                    turma_ids: teacherDrafts[formadorId] || [],
                });
            }

            setMessage("User updated successfully.");

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
                                                        {roleLabel(role)}
                                                    </option>
                                                ))}
                                            </select>
                                        </div>

                                        {isStudentRole(
                                            teacherRoleDrafts[formador.id] ||
                                                formador.role_id,
                                        ) && (
                                            <>
                                                <p className="admin-dashboard__field-label">
                                                    Student class
                                                </p>
                                                <select
                                                    className="admin-dashboard__select admin-dashboard__select--wide"
                                                    value={
                                                        studentDrafts[
                                                            formador.id
                                                        ]?.turma_id || ""
                                                    }
                                                    onChange={(event) =>
                                                        updateStudentDraft(
                                                            formador.id,
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
                                            </>
                                        )}

                                        {isTeacherRole(
                                            teacherRoleDrafts[formador.id] ||
                                                formador.role_id,
                                        ) && (
                                            <>
                                                {/* Checkboxes para escolher as turmas atribuídas ao professor. */}
                                                <p className="admin-dashboard__field-label">
                                                    Classes assigned to this
                                                    teacher
                                                </p>
                                                <div className="admin-dashboard__class-list">
                                                    {turmas.length === 0 ? (
                                                        <p className="admin-dashboard__empty-note">
                                                            No classes available
                                                            yet.
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
                                                                            formador
                                                                                .id
                                                                        ]?.includes(
                                                                            turma.id,
                                                                        ) ||
                                                                        false
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
                                            </>
                                        )}

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
                                                        {roleLabel(role)}
                                                    </option>
                                                ))}
                                            </select>

                                            {isStudentRole(
                                                studentDrafts[aluno.id]
                                                    ?.role_id || aluno.role_id,
                                            ) && (
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
                                            )}
                                        </div>

                                        {isTeacherRole(
                                            studentDrafts[aluno.id]?.role_id ||
                                                aluno.role_id,
                                        ) && (
                                            <>
                                                <p className="admin-dashboard__field-label">
                                                    Classes assigned to this
                                                    teacher
                                                </p>
                                                <div className="admin-dashboard__class-list">
                                                    {turmas.length === 0 ? (
                                                        <p className="admin-dashboard__empty-note">
                                                            No classes available
                                                            yet.
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
                                                                            aluno
                                                                                .id
                                                                        ]?.includes(
                                                                            turma.id,
                                                                        ) ||
                                                                        false
                                                                    }
                                                                    onChange={() =>
                                                                        toggleTeacherTurma(
                                                                            aluno.id,
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
                                            </>
                                        )}

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

                    <section className="cls__card">
                        <header className="cls__card-head">
                            <h2 className="cls__card-name">New</h2>
                            <span className="cls__card-count">
                                {newUsers.length} pending
                            </span>
                        </header>

                        {newUsers.length === 0 ? (
                            <div className="mb__empty">
                                <p className="mb__empty-text">
                                    There are no new people waiting for a role.
                                </p>
                            </div>
                        ) : (
                            <div className="cls__grid admin-dashboard__student-grid">
                                {newUsers.map((user) => {
                                    const draft = newUserDrafts[user.id] || {
                                        role_id: user.role_id,
                                        turma_id: "",
                                        turma_ids: [],
                                    };
                                    const draftRoleName = selectedRoleName(
                                        draft.role_id,
                                    );
                                    const draftIsTeacher = [
                                        "formador",
                                        "teacher",
                                        "professor",
                                    ].includes(draftRoleName);
                                    const draftIsStudent = [
                                        "user",
                                        "student",
                                        "aluno",
                                    ].includes(draftRoleName);

                                    return (
                                        <article
                                            key={user.id}
                                            className="cls__project admin-dashboard__user-card"
                                        >
                                            <div className="cls__project-body">
                                                <h3 className="cls__project-title">
                                                    {user.name}
                                                </h3>
                                                <p className="cls__project-student">
                                                    {user.email}
                                                </p>

                                                <div className="admin-dashboard__student-controls">
                                                    {/* Select para decidir se a pessoa nova será aluno ou professor. */}
                                                    <select
                                                        className="admin-dashboard__select"
                                                        value={draft.role_id}
                                                        onChange={(event) =>
                                                            updateNewUserDraft(
                                                                user.id,
                                                                "role_id",
                                                                event.target
                                                                    .value,
                                                            )
                                                        }
                                                    >
                                                        {roles
                                                            .filter((role) =>
                                                                [
                                                                    2, 3,
                                                                ].includes(
                                                                    Number(
                                                                        role.id,
                                                                    ),
                                                                ),
                                                            )
                                                            .map((role) => (
                                                                <option
                                                                    key={
                                                                        role.id
                                                                    }
                                                                    value={
                                                                        role.id
                                                                    }
                                                                >
                                                                    {roleLabel(
                                                                        role,
                                                                    )}
                                                                </option>
                                                            ))}
                                                    </select>

                                                    {draftIsStudent && (
                                                        <select
                                                            className="admin-dashboard__select admin-dashboard__select--wide"
                                                            value={
                                                                draft.turma_id ||
                                                                ""
                                                            }
                                                            onChange={(event) =>
                                                                updateNewUserDraft(
                                                                    user.id,
                                                                    "turma_id",
                                                                    event.target
                                                                        .value,
                                                                )
                                                            }
                                                        >
                                                            <option value="">
                                                                No class
                                                                assigned
                                                            </option>

                                                            {turmas.map(
                                                                (turma) => (
                                                                    <option
                                                                        key={
                                                                            turma.id
                                                                        }
                                                                        value={
                                                                            turma.id
                                                                        }
                                                                    >
                                                                        {
                                                                            turma.name
                                                                        }
                                                                    </option>
                                                                ),
                                                            )}
                                                        </select>
                                                    )}
                                                </div>

                                                {draftIsTeacher && (
                                                    <>
                                                        <p className="admin-dashboard__field-label">
                                                            Classes assigned to
                                                            this teacher
                                                        </p>
                                                        <div className="admin-dashboard__class-list">
                                                            {turmas.length ===
                                                            0 ? (
                                                                <p className="admin-dashboard__empty-note">
                                                                    No classes
                                                                    available
                                                                    yet.
                                                                </p>
                                                            ) : (
                                                                turmas.map(
                                                                    (turma) => (
                                                                        <label
                                                                            key={
                                                                                turma.id
                                                                            }
                                                                            className="admin-dashboard__checkbox"
                                                                        >
                                                                            <input
                                                                                type="checkbox"
                                                                                checked={
                                                                                    draft.turma_ids?.includes(
                                                                                        turma.id,
                                                                                    ) ||
                                                                                    false
                                                                                }
                                                                                onChange={() =>
                                                                                    toggleNewUserTurma(
                                                                                        user.id,
                                                                                        turma.id,
                                                                                    )
                                                                                }
                                                                            />
                                                                            <span>
                                                                                {
                                                                                    turma.name
                                                                                }
                                                                            </span>
                                                                        </label>
                                                                    ),
                                                                )
                                                            )}
                                                        </div>
                                                    </>
                                                )}

                                                <button
                                                    type="button"
                                                    className="mb__btn mb__btn--solid"
                                                    onClick={() =>
                                                        saveNewUser(user.id)
                                                    }
                                                    disabled={
                                                        savingNewUserId ===
                                                        user.id
                                                    }
                                                >
                                                    {savingNewUserId === user.id
                                                        ? "Saving..."
                                                        : "Save"}
                                                </button>
                                            </div>
                                        </article>
                                    );
                                })}
                            </div>
                        )}
                    </section>
                </div>
            </main>
        </div>
    );
}
