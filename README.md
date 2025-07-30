# Blog de Reviews de Jogos

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![CSS](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![Status](https://img.shields.io/badge/status-Concluído-green.svg)

> Plataforma web onde usuários podem postar suas próprias análises (reviews) de jogos, atribuir notas e interagir através de comentários. Projeto desenvolvido para a disciplina de Projeto Integrado de Sistemas de Informação para Negócios.


## 📖 Sobre o Projeto

Uma aplicação web desenvolvida para ser um espaço comunitário para amantes de jogos eletrônicos. A plataforma permite que qualquer pessoa crie uma conta e comece a compartilhar suas experiências, escrevendo análises detalhadas e dando uma nota de avaliação para seus jogos favoritos.

O foco do projeto foi criar um sistema dinâmico e interativo, utilizando **PHP** para o processamento no lado do servidor e **MySQL** para armazenar todos os dados, desde informações de usuários até as reviews e comentários. É um sistema completo que gerencia todo o ciclo de vida de uma postagem, desde sua criação até a interação da comunidade.

---

## ✨ Funcionalidades Principais

Baseado nos arquivos do projeto, estas são as funcionalidades implementadas:

- **👤 Gestão de Contas de Usuário (CRUD Completo):**
  - `cadastrar.php`: Permite que novos usuários criem uma conta.
  - `login.php` / `logout.php`: Sistema de autenticação para acessar e sair da plataforma.
  - `atualizarPerfil.php`: Usuários podem editar as informações de seu próprio perfil.
  - `excluir.php`: Opção para o usuário excluir sua própria conta.

- **📝 Gestão de Reviews de Jogos (CRUD Completo):**
  - `cadastrarReview.php`: Usuários logados podem escrever uma nova análise, incluindo um título, o corpo do texto e uma **nota** para o jogo.
  - `updateReview.php`: Permite que o autor de uma review a edite posteriormente.
  - `excluirReview.php`: Permite que o autor remova sua própria review.

- **💬 Sistema de Comentários:**
  - `comentario.php`: Usuários logados podem ler e adicionar comentários nas reviews publicadas por outras pessoas, promovendo a discussão.

- **🕹️ Feed Principal:**
  - Uma página inicial que exibe as reviews mais recentes publicadas por todos os usuários, servindo como um feed de conteúdo.

---

## 🛠️ Tecnologias Utilizadas

- **Backend:** `PHP`
- **IDE:** `NetBeans`
- **Banco de Dados:** `MySQL`
- **Frontend:** `HTML`, `CSS`
- **Ambiente de Servidor:** `XAMPP`

---

## 👨‍💻 Autor

Desenvolvido por **Wallace Castro de Oliveira**.
