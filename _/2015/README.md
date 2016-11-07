# Linked Open Data Challenge 2015

This repository is the source codes of Web site of Linked Open Data Challenge 2015.


## Gitを使った共同編集

最初に、git-ftpに必要なパッケージをインストール。

```
$ brew install git git-ftp     (Mac)
$ sudo yum install git  git-ftp   (Redhat系)
$ sudo aptitude install git  git-ftp   (Debian系)
```

LODチャレンジ2015のmasterレポジトリをcloneする。

```
$ git clone git@github.com:LinkedOpenData/challenge2015.git
```

レポジトリ内で編集用ブランチを作りmasterから切り替える（初回のみ）。

```
$ cd challenge2015
$ git status
$ git branch <ブランチ名>
$ git checkout <ブランチ名>
$ git status
```

編集作業後、コミット用の操作。

```
$ git status
<<<<<<< HEAD
$ git add .
=======
>>>>>>> origin/master
$ git add . -u 
$ git commit -m “<コメント>"
$ git status
```

GitHubへのpush操作はGitHubアカウントと、レポジトリにSSH公開鍵の登録が必要。

```
$ git push
```

GitHub Webサイトで確認して、mergeして良ければGUIでmergeリクエスト。
委員会のメンバーは管理者グループに入れますので、
自分でリクエストに応えてmergeしてください。
慣れている人はコマンドラインで実行しても良いでしょう。

---

## git-ftp を使ったFTP経由でのWebサーバーへのレポジトリのデプロイ

git-ftpの初期設定（初回のみ）。

```
$ git config git-ftp.url <FTPホスト名>
$ git config git-ftp.user <FTPユーザー名>
$ git config git-ftp.password <FTPパスワード>
```

git-ftpとの同期（初回のみ）

```
$ git ftp init
```

git-ftpへのアップロード（２回目以降）

```
$ git ftp push
```

アップロード後はFilezilaなどクライアントソフトで正常かどうか確認して下さい。
https://filezilla-project.org/
