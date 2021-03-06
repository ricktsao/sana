/**
 * Simplified Chinese translation
 * @author 翻譯者 
 * @version 2011-09-08
 */
if (elFinder && elFinder.prototype && typeof(elFinder.prototype.i18) == 'object') {
	elFinder.prototype.i18.zh-tw = {
		translator : '翻譯者',
		language   : '繁體中文',
		direction  : 'ltr',
		messages   : {
			
			/********************************** errors **********************************/
			'error'                : '錯誤',
			'errUnknown'           : '未知的錯誤.',
			'errUnknownCmd'        : '未知的命令.',
			'errJqui'              : '無效的 jQuery UI 配置. 必須包含 Selectable, draggable 以及 droppable 元件.',
			'errNode'              : 'elFinder 需要能創建 DOM 元素.',
			'errURL'               : '無效的 elFinder 配置! URL 選項未配置.',
			'errAccess'            : '訪問被拒絕.',
			'errConnect'           : '不能連接到後端.',
			'errAbort'             : '連接中止.',
			'errTimeout'           : '連接逾時.',
			'errNotFound'          : '未找到後端.',
			'errResponse'          : '無效的後端回應.',
			'errConf'              : '無效的後端配置.',
			'errJSON'              : 'PHP JSON 模組未安裝.',
			'errNoVolumes'         : '無可讀的卷.',
			'errCmdParams'         : '無效的參數, 命令: "$1".',
			'errDataNotJSON'       : '回應不符合 JSON 格式.',
			'errDataEmpty'         : '回應為空.',
			'errCmdReq'            : '後端請求需要命令名稱.',
			'errOpen'              : '無法打開 "$1".',
			'errNotFolder'         : '對象不是資料夾.',
			'errNotFile'           : '對象不是檔.',
			'errRead'              : '無法讀取 "$1".',
			'errWrite'             : '無法寫入 "$1".',
			'errPerm'              : '無許可權.',
			'errLocked'            : '"$1" 被鎖定,不能重命名, 移動或刪除.',
			'errExists'            : '檔 "$1" 已經存在了.',
			'errInvName'           : '無效的檔案名.',
			'errFolderNotFound'    : '未找到資料夾.',
			'errFileNotFound'      : '未找到文件.',
			'errTrgFolderNotFound' : '未找到目的檔案夾 "$1".',
			'errPopup'             : '流覽器攔截了快顯視窗. 請在選項中允許快顯視窗.',
			'errMkdir'             : '不能創建資料夾 "$1".',
			'errMkfile'            : '不能創建檔 "$1".',
			'errRename'            : '不能重命名 "$1".',
			'errCopyFrom'          : '不允許從卷 "$1" 複製.',
			'errCopyTo'            : '不允許向卷 "$1" 複製.',
			'errUploadCommon'      : '上傳出錯.',
			'errUpload'            : '無法上傳 "$1".',
			'errUploadNoFiles'     : '未找到要上傳的文件.',
			'errMaxSize'           : '資料超過了允許的最大大小.',
			'errFileMaxSize'       : '檔超過了允許的最大大小.',
			'errUploadMime'        : '不允許的檔案類型.',
			'errUploadTransfer'    : '"$1" 傳輸錯誤.', 
			'errSave'              : '無法保存 "$1".',
			'errCopy'              : '無法複製 "$1".',
			'errMove'              : '無法移動 "$1".',
			'errCopyInItself'      : '不能移動 "$1" 到原有位置.',
			'errRm'                : '無法刪除 "$1".',
			'errExtract'           : '無法從 "$1" 提取文件.',
			'errArchive'           : '無法創建壓縮檔.',
			'errArcType'           : '不支援的壓縮格式.',
			'errNoArchive'         : '檔不是壓縮檔, 或者不支持該壓縮格式.',
			'errCmdNoSupport'      : '後端不支援該命令.',
			
			/******************************* commands names ********************************/
			'cmdarchive'   : '創建壓縮檔',
			'cmdback'      : '後退',
			'cmdcopy'      : '複製',
			'cmdcut'       : '剪切',
			'cmddownload'  : '下載',
			'cmdduplicate' : '創建複本',
			'cmdedit'      : '編輯檔',
			'cmdextract'   : '從壓縮檔提取檔',
			'cmdforward'   : '前進',
			'cmdgetfile'   : '選擇檔',
			'cmdhelp'      : '關於本軟體',
			'cmdhome'      : '首頁',
			'cmdinfo'      : '查看信息',
			'cmdmkdir'     : '新建資料夾',
			'cmdmkfile'    : '新建文字檔',
			'cmdopen'      : '打開',
			'cmdpaste'     : '粘貼',
			'cmdquicklook' : '預覽',
			'cmdreload'    : '刷新',
			'cmdrename'    : '重命名',
			'cmdrm'        : '刪除',
			'cmdsearch'    : '查找文件',
			'cmdup'        : '轉到上一級資料夾',
			'cmdupload'    : '上傳文件',
			'cmdview'      : '查看',
			
			/*********************************** buttons ***********************************/ 
			'btnClose'  : '關閉',
			'btnSave'   : '保存',
			'btnRm'     : '刪除',
			'btnCancel' : '取消',
			'btnNo'     : '否',
			'btnYes'    : '是',
			
			/******************************** notifications ********************************/
			'ntfopen'     : '打開資料夾',
			'ntffile'     : '打開文件',
			'ntfreload'   : '刷新資料夾內容',
			'ntfmkdir'    : '創建資料夾',
			'ntfmkfile'   : '創建文件',
			'ntfrm'       : '刪除檔',
			'ntfcopy'     : '複製檔案',
			'ntfmove'     : '移動文件',
			'ntfprepare'  : '準備複製文件',
			'ntfrename'   : '重命名檔',
			'ntfupload'   : '上傳文件',
			'ntfdownload' : '下載檔案',
			'ntfsave'     : '保存檔',
			'ntfarchive'  : '創建壓縮檔',
			'ntfextract'  : '從壓縮檔提取檔',
			'ntfsearch'   : '搜索文件',
			'ntfsmth'     : '正在忙 >_<',
			
			/************************************ dates **********************************/
			'dateUnknown' : '未知',
			'Today'       : '今天',
			'Yesterday'   : '昨天',
			'Jan'         : '一月',
			'Feb'         : '二月',
			'Mar'         : '三月',
			'Apr'         : '四月',
			'May'         : '五月',
			'Jun'         : '六月',
			'Jul'         : '七月',
			'Aug'         : '八月',
			'Sep'         : '九月',
			'Oct'         : '十月',
			'Nov'         : '十一月',
			'Dec'         : '十二月',

			/********************************** messages **********************************/
			'confirmReq'      : '請確認',
			'confirmRm'       : '確定要刪除檔嗎?<br/>該操作不可撤銷!',
			'confirmRepl'     : '用新的檔替換原有檔?',
			'apllyAll'        : '全部應用',
			'name'            : '名稱',
			'size'            : '大小',
			'perms'           : '許可權',
			'modify'          : '修改於',
			'kind'            : '類別',
			'read'            : '讀取',
			'write'           : '寫入',
			'noaccess'        : '無許可權',
			'and'             : '和',
			'unknown'         : '未知',
			'selectall'       : '選擇所有檔案',
			'selectfiles'     : '選擇檔案',
			'selectffile'     : '選擇第一個檔案',
			'selectlfile'     : '選擇最後一個檔案',
			'viewlist'        : '列表視圖',
			'viewicons'       : '圖示視圖',
			'places'          : '位置',
			'calc'            : '計算', 
			'path'            : '路徑',
			'aliasfor'        : '別名',
			'locked'          : '鎖定',
			'dim'             : '尺寸',
			'files'           : '文件',
			'folders'         : '資料夾',
			'items'           : '項目',
			'yes'             : '是',
			'no'              : '否',
			'link'            : '連結',
			'searcresult'     : '搜索結果',  
			'selected'        : '選中的項目',
			'about'           : '關於',
			'shortcuts'       : '快速鍵',
			'help'            : '幫助',
			'webfm'           : '網路檔案管理員',
			'ver'             : '版本',
			'protocol'        : '協議版本',
			'homepage'        : '項目主頁',
			'docs'            : '文件',
			'github'          : 'Fork us on Github',
			'twitter'         : 'Follow us on twitter',
			'facebook'        : 'Join us on facebook',
			'team'            : '團隊',
			'chiefdev'        : '首席開發',
			'developer'       : '開發',
			'contributor'     : '貢獻',
			'maintainer'      : '維護',
			'translator'      : '翻譯',
			'icons'           : '圖示',
			'dontforget'      : 'don\'t forget',
			'shortcutsof'     : '快速鍵已禁用',
			'dropFiles'       : '把檔拖到這裡',
			'or'              : '或者',
			'selectForUpload' : '選擇要上傳的檔案',
			'moveFiles'       : '移動檔案',
			'copyFiles'       : '複製檔案',
			
			/********************************** mimetypes **********************************/
			'kindUnknown'     : '未知',
			'kindFolder'      : '資料夾',
			'kindAlias'       : '別名',
			'kindAliasBroken' : '錯誤的別名',
			// applications
			'kindApp'         : '程式',
			'kindPostscript'  : 'Postscript 文件',
			'kindMsOffice'    : 'Microsoft Office 文件',
			'kindMsWord'      : 'Microsoft Word 文件',
			'kindMsExcel'     : 'Microsoft Excel 文件',
			'kindMsPP'        : 'Microsoft Powerpoint 文件',
			'kindOO'          : 'Open Office 文件',
			'kindAppFlash'    : 'Flash 程式',
			'kindPDF'         : 'Portable Document Format (PDF)',
			'kindTorrent'     : 'Bittorrent 文件',
			'kind7z'          : '7z 壓縮檔',
			'kindTAR'         : 'TAR 壓縮檔',
			'kindGZIP'        : 'GZIP 壓縮檔',
			'kindBZIP'        : 'BZIP 壓縮檔',
			'kindZIP'         : 'ZIP 壓縮檔',
			'kindRAR'         : 'RAR 壓縮檔',
			'kindJAR'         : 'Java JAR 文件',
			'kindTTF'         : 'True Type 字體',
			'kindOTF'         : 'Open Type 字體',
			'kindRPM'         : 'RPM 包',
			// texts
			'kindText'        : '文字檔',
			'kindTextPlain'   : '純文字',
			'kindPHP'         : 'PHP 程式碼',
			'kindCSS'         : '層疊樣式表(CSS)',
			'kindHTML'        : 'HTML 文件',
			'kindJS'          : 'Javascript 程式碼',
			'kindRTF'         : '富文本格式(RTF)',
			'kindC'           : 'C 程式碼',
			'kindCHeader'     : 'C 標頭檔',
			'kindCPP'         : 'C++ 程式碼',
			'kindCPPHeader'   : 'C++ 標頭檔',
			'kindShell'       : 'Unix 外殼腳本',
			'kindPython'      : 'Python 程式碼',
			'kindJava'        : 'Java 程式碼',
			'kindRuby'        : 'Ruby 程式碼',
			'kindPerl'        : 'Perl 程式碼',
			'kindSQL'         : 'SQL 腳本',
			'kindXML'         : 'XML 文件',
			'kindAWK'         : 'AWK 程式碼',
			'kindCSV'         : '逗號分隔值文件(CSV)',
			'kindDOCBOOK'     : 'Docbook XML 文件',
			// images
			'kindImage'       : '圖片',
			'kindBMP'         : 'BMP 圖片',
			'kindJPEG'        : 'JPEG 圖片',
			'kindGIF'         : 'GIF 圖片',
			'kindPNG'         : 'PNG 圖片',
			'kindTIFF'        : 'TIFF 圖片',
			'kindTGA'         : 'TGA 圖片',
			'kindPSD'         : 'Adobe Photoshop 圖片',
			'kindXBITMAP'     : 'X bitmap 圖片',
			'kindPXM'         : 'Pixelmator 圖片',
			// media
			'kindAudio'       : '聲音檔',
			'kindAudioMPEG'   : 'MPEG 聲音檔',
			'kindAudioMPEG4'  : 'MPEG-4 聲音檔',
			'kindAudioMIDI'   : 'MIDI 聲音檔',
			'kindAudioOGG'    : 'Ogg Vorbis 聲音檔',
			'kindAudioWAV'    : 'WAV 聲音檔',
			'AudioPlaylist'   : 'MP3 播放清單',
			'kindVideo'       : '影片檔',
			'kindVideoDV'     : 'DV 影片檔',
			'kindVideoMPEG'   : 'MPEG 影片檔',
			'kindVideoMPEG4'  : 'MPEG-4 影片檔',
			'kindVideoAVI'    : 'AVI 影片檔',
			'kindVideoMOV'    : 'Quick Time 影片檔',
			'kindVideoWM'     : 'Windows Media 影片檔',
			'kindVideoFlash'  : 'Flash 影片檔',
			'kindVideoMKV'    : 'Matroska 影片檔',
			'kindVideoOGG'    : 'Ogg 影片檔'
		}
	};
}
