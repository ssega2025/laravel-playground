# Git運用ルール

## 概要

各プロジェクトには、基本として以下のブランチがあります。

- `master`
- `staging`

それぞれ役割が異なるため、ブランチの切り方・merge先を誤らないことが重要です。

---

## 各ブランチの役割

### master
- 本番環境用のブランチ
- `push` や `merge` により、本番サイトへ反映される

### staging
- テスト環境用のブランチ
- 本番反映前に、動作確認・テストを行うためのブランチ

---

## staging ブランチの扱い

`staging` はテスト環境用のため、以下の特徴があります。

- 本番に入れてはいけない実験的な要素が含まれることがある
- 一時的な確認用の変更が入ることがある

そのため、以下は **基本NG** とします。

- `staging` から作業ブランチを切る
- `staging` の内容をそのまま `master` に merge する
- 作業ブランチに `staging` を merge する

作業ブランチに `staging` を取り込むと、PR上で本来関係のない差分やコミット履歴が混ざり、変更内容や履歴が追いづらくなることがあります。

---

## 開発時の基本ルール

新機能実装や修正対応を行う場合は、必ず以下の流れで進めます。

### 1. 作業ブランチは master から切る
- 開発用の作業ブランチは、必ず `master` から作成する

### 2. チームでまとまった作業を行う場合
- `master` から `〇〇_release_master` ブランチを作成する
- 各作業ブランチは `〇〇_release_master` に merge していく

### 3. staging に反映する前の対応
- `staging` の内容を本番と揃えるため、先に `master` を `staging` に merge する
- その後、`〇〇_release_master` の内容を `staging` に反映する

### 4. staging で確認する
- staging 環境で動作確認・テストを行う

### 5. 問題がなければ本番反映する
- `〇〇_release_master` から `master` に対して Pull Request を作成する
- 承認後、`master` に merge する

---

## 一連の流れ

1. `master` から作業ブランチを切る  
2. チーム作業用に `master` から `〇〇_release_master` を切る  
3. 各作業ブランチを `〇〇_release_master` に merge する  
4. `master` を `staging` に merge して、本番相当の状態に揃える  
5. `〇〇_release_master` を `staging` に反映する  
6. staging 環境で確認・テストを行う  
7. 問題なければ `〇〇_release_master` から `master` へ Pull Request を作成し、merge する  

---

## コンフリクト発生時の対応

コンフリクトが発生した場合は、**基本的にローカルで対象ブランチを最新化したうえで解消する**。  
GitHub上でそのまま対応するのではなく、ローカルで内容を確認しながら慎重に解消すること。

---

## 基本方針

- 関係するブランチをローカルで最新化する
- コンフリクトはローカルで解消する
- 解消後は対象ブランチへ push し、Pull Request に反映させる
- **作業ブランチに `staging` は merge しない**
- どのブランチを取り込むかは、PRの向きとブランチの役割を基準に判断する

---

## パターン別の対応

### 1. `〇〇_release_master` → `master` の Pull Request でコンフリクトが起きた場合

#### 対応方針
- ローカルの `master` を最新化する
- ローカルの `〇〇_release_master` に `master` を取り込む
- `〇〇_release_master` 側でコンフリクトを解消する
- 解消後、`〇〇_release_master` を push する

#### 理由
`master` に対する PR であるため、`master` の最新状態を `〇〇_release_master` に反映して整合を取る。

---

### 2. `〇〇_release_master` → `staging` の Pull Request でコンフリクトが起きた場合

#### 対応方針
- ローカルの `staging` を最新化する
- ローカルの `〇〇_release_master` に `staging` を取り込む
- `〇〇_release_master` 側でコンフリクトを解消する
- 解消後、`〇〇_release_master` を push する

#### 理由
`staging` に対する PR であるため、`staging` の最新状態を `〇〇_release_master` に反映して整合を取る。

#### 注意
- `staging` には実験的な変更が含まれることがある
- そのため、取り込む差分は内容をよく確認する
- **この取り込みは `〇〇_release_master` に対して行い、作業ブランチには行わない**

---

### 3. 作業ブランチ → `〇〇_release_master` の Pull Request でコンフリクトが起きた場合

#### 対応方針
- ローカルの `〇〇_release_master` を最新化する
- ローカルの作業ブランチに `〇〇_release_master` を取り込む
- 作業ブランチ側でコンフリクトを解消する
- 解消後、作業ブランチを push する

#### 理由
`〇〇_release_master` に対する PR であるため、ベースブランチである `〇〇_release_master` の最新状態を作業ブランチに反映して整合を取る。

---

## 禁止・注意事項

### 作業ブランチに `staging` を merge しない
以下は基本的に NG とする。

- 作業ブランチに `staging` を merge する
- `staging` を取り込んだ状態の作業ブランチを push する

#### 理由
- 本来関係ない `staging` の変更が作業ブランチに混ざる
- PRの差分が見づらくなる
- コミット履歴が追いにくくなる
- 何のための変更か分かりづらくなる

---

## まとめ

- 作業ブランチの作成元は必ず `master`
- `staging` は確認用ブランチであり、開発の起点にしない
- 本番反映は `staging` からではなく、`〇〇_release_master` から `master` に対して行う
- `staging` には実験的要素が含まれる可能性があるため、内容をそのまま本番に持ち込まない
- コンフリクトはローカルで解消する
- **作業ブランチには `staging` を取り込まない**