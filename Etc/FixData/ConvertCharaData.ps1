$scriptPath = Get-Location
$excelFileName = "FixData.xlsm"
$excelFunctionName = "OutputCharaFixData"
$excelPath = Join-Path $scriptPath $excelFileName
if(Test-Path $excelPath){
    $writeString = $excelFileName + "の関数" + $excelFunctionName + "を呼び出しています."
    Write-Output $writeString

    # Excelオブジェクトを取得
    $excel = New-Object -ComObject Excel.Application
    try
    {
        # ExcelファイルをOPEN
        $book = $excel.Workbooks.Open($excelPath)
        # プロシージャを実行
        $excel.Run($excelFunctionName)
        # ExcelファイルをCLOSE
        $book.Close()
    }
    catch
    {
        $ws = New-Object -ComObject Wscript.Shell
        $ws.popup("エラー : " + $PSItem)
    }
    finally
    {
        # Excelを終了
        $excel.Quit()
        [System.Runtime.InteropServices.Marshal]::FinalReleaseComObject($excel) | Out-Null

        $writeString = $excelFileName + "の関数" + $excelFunctionName + "を正常終了."
        Write-Output $writeString
    }

    #成果物をutf-8に変換する.
    $sourceFileName = "CharaFixData.csv"
    $sourcePath = Join-Path $scriptPath $sourceFileName
    $allText = Get-Content $sourcePath -Encoding default
    Write-Output $allText | Out-File $sourcePath -Encoding UTF8
    $writeString = $sourceFileName + "をShift_JISからutf-8(BOM付き)に変換しました."
    Write-Output $writeString

    #成果物をAsset以下に移動.
    $destPath = Join-Path $scriptPath "..\..\Assets\Resources\FixData"
    if(Test-Path $destPath){
        Move-Item -Path $sourcePath -Destination $destPath -Force
        $writeString = $sourceFileName + "を" + $destPath + "に配置しました."
        Write-Output $writeString
    }else{
        $writeString = $destPath + "がありません. ERROR!!!!!"
        Write-Error $writeSt
        Read-Host "Enterキーで終了"
    }
    

}else{
    $writeString = $excelPath + "がありません. ERROR!!!!!"
    Write-Error $writeString
    Read-Host "Enterキーで終了"
}