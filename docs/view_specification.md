#画面仕様
##一般画面
###トップページ
/homes/index/
/
コミュニティ一覧を表示
プロジェクト一覧を表示
ユーザーログインへのリンク
ユーザー登録へのリンク


+ /homes/view_community/{community_id}
++ /vc/co{community_id}
コミュニティの情報を表示する
プロジェクトの一覧を表示する
Threadの一覧を表示する

+ /homes/view_thread/{thread_id}
++ /vt/th{community_id}
	Commentの一覧を表示する


##ログイン後
###ダッシュボード
+ /mochi/
	^ view
		通知されているActivityを表示
###ユーザー
+ /users
	^ view
		ユーザー一覧
	- link
		+ /users/{user_id}

+ /users/view/{user_id}
	^ view
		Follow数
		Follower数
		ポートフォリオ一覧を表示
		実績を表示
	^ link
	- 自分の場合
		+ /portfolios/add
			Portfolioの追加
		+ /users/edit
			ユーザー情報の編集
		+ /notification/edit
			Notificatonの編集
	- 人様の場合
		+ /follow/add
			Followの追加
		+ /portfolios
			ポートフォリオ一覧の表示
	- 共通
	Portfolioを表示する public
	Achievementを表示する all
+ /portfolios/{portfolio_id}
	- 自分の場合
		ポートフォリオの編集
	- 人様の場合
		ポートフォリオ閲覧

	

###コミュニティ
+ /comunity/communities/
	コミュニティの一覧

+ /comunity/communities/add/
	コミュニティの追加

+ /comunity/communities/view/{community_id}
++ /m/co{community_id}
	- コミュニティに入っている
		- 管理人/副管理人
			Bodyの変更
			サムネイルの変更
		- 一般
		公開してある情報が見れる
	- コミュニティに入っていない
		+ /communities/join/
			Communityに参加
	-共通
		^ view
		以下の４つの一部の一覧が見える
		menbers
		projects
		threads
		activities
		^ link
		+ /community/members/
			Member一覧が見える public/private
		+ /community/projects/
			Project一覧が見える public/private
		+ /community/threads/
			Thread一覧が見える public/private
		+ /community/activities/
			Activity一覧が見える public/private
		+ /community/calendars/
			Calendarが見える public/private

+ /community/members/{memeber_id}
	コミュニティメンバーのユーザーページへのリンク


+ /comunity/projects/{project_id}
	ProjectMember一覧が見える
	Progress一覧が見える
	Resultが見れる
	+ /projects/add_progress
		マイルストーン(Progress)を作成する

	
	- プロジェクトに入っている
		+ /communities/add_project/
			Projectの追加
	- プロジェクトに入っていない
		+ /communities/join_project/
			Projectに参加


	
/communities/view_project/communitiy_id:30/project_id:22

/コントローラー/アクション/パラメータ/パラメータ/パラメータ/


