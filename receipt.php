<?php
// error_reporting(E_ALL); 
// ini_set('display_errors', 1);
ob_start();
include 'db.php'; 

include('vendor/autoload.php');

$sitename = "Hybreed Courier Trackr";
	
if (isset($_GET['tnum']) && $_GET['tnum'] != "") {
	$tnumber = $_GET['tnum'];
	$select = mysqli_query($link, "SELECT * FROM tracking WHERE tracking_number = '$tnumber' ");
    if (mysqli_num_rows($select) > 0) {
        $data = mysqli_fetch_assoc($select);

        $history_rows = array();
        $colCheck = mysqli_query($link, "SHOW COLUMNS FROM shipment_history LIKE 'custom_date'");
        $hasCustomDate = ($colCheck && mysqli_num_rows($colCheck) > 0);
        if ($hasCustomDate) {
            $history_query = mysqli_query($link, "SELECT status, location, remarks, custom_date, created_at FROM shipment_history WHERE tracking_number = '$tnumber' ORDER BY COALESCE(custom_date, created_at) DESC");
        } else {
            $history_query = mysqli_query($link, "SELECT status, location, remarks, created_at FROM shipment_history WHERE tracking_number = '$tnumber' ORDER BY created_at DESC");
        }
        if ($history_query && mysqli_num_rows($history_query) > 0) {
            while ($row = mysqli_fetch_assoc($history_query)) { $history_rows[] = $row; }
        }

        $baseDir = __DIR__;
        $logoCandidates = array(
            $baseDir.'/uploads/branding/logo/logo.png',
            $baseDir.'/uploads/branding/logo/logo.jpg',
            $baseDir.'/logo/logo.png',
            $baseDir.'/images/logo.png'
        );
        $signatureCandidates = array(
            $baseDir.'/uploads/branding/signature/signature.png',
            $baseDir.'/uploads/branding/signature/signature.jpg'
        );
        $stampCandidates = array(
            $baseDir.'/uploads/branding/stamp/stamp.png',
            $baseDir.'/uploads/branding/stamp/stamp.jpg'
        );

        $toDataUri = function($paths) {
            foreach ($paths as $p) {
                if (is_file($p)) {
                    $ext = strtolower(pathinfo($p, PATHINFO_EXTENSION));
                    $mime = ($ext === 'jpg' || $ext === 'jpeg') ? 'image/jpeg' : (($ext === 'png') ? 'image/png' : 'application/octet-stream');
                    $raw = @file_get_contents($p);
                    if ($raw !== false) {
                        return 'data:'.$mime.';base64,'.base64_encode($raw);
                    }
                    return '';
                }
            }
            return '';
        };

        $logoSrc = $toDataUri($logoCandidates);
        $signatureSrc = $toDataUri($signatureCandidates);
        $stampSrc = $toDataUri($stampCandidates);

        $createdDate = date('M d, Y');
        $createdTime = date('h:i A');
        $historyHtml = '';
        if (!empty($history_rows)) {
            foreach ($history_rows as $h) {
                $display_date = isset($h['custom_date']) && !empty($h['custom_date']) ? $h['custom_date'] : (isset($h['created_at']) ? $h['created_at'] : '');
                $historyHtml .= '<tr>'
                    .'<td>'.htmlspecialchars(date('M d, Y h:i A', strtotime($display_date))).'</td>'
                    .'<td>'.htmlspecialchars($h['status'] ?? '').'</td>'
                    .'<td>'.htmlspecialchars($h['location'] ?? '').'</td>'
                    .'<td>'.htmlspecialchars($h['remarks'] ?? '').'</td>'
                    .'</tr>';
            }
        } else {
            $historyHtml = '<tr><td colspan="4" style="text-align:center; color:#777;">No shipment history available.</td></tr>';
        }

        $brandHtml = $logoSrc !== ''
            ? '<img src="'.$logoSrc.'" style="height:50px;" />'
            : '<div style="font-size:22px; font-weight:700;">'.$sitename.'</div>';

        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color:#333; }
        .receipt { max-width: 850px; margin: 0 auto; padding: 24px; border:1px solid #eee; }
        .header { display: flex; align-items: center; justify-content: space-between; border-bottom:2px solid #f0f0f0; padding-bottom: 12px; }
        .title { font-size: 22px; font-weight: 700; margin: 8px 0 0; }
        .meta { text-align: right; font-size: 12px; color:#666; }
        .subtle { color:#666; font-size:12px; }
        .grid { width:100%; border-collapse: collapse; margin-top:14px; }
        .grid td, .grid th { padding:8px 10px; border:1px solid #eee; font-size: 13px; }
        .grid th { background:#fafafa; text-align:left; }
        .columns { display:flex; gap:16px; margin-top:16px; }
        .col { flex:1; border:1px solid #eee; padding:10px; }
        .section-title { font-weight:700; margin:0 0 6px; font-size:14px; }
        .history-table { width:100%; border-collapse: collapse; margin-top:10px; }
        .history-table th, .history-table td { padding:8px 10px; border:1px solid #eee; font-size:12px; }
        .history-table th { background:#fafafa; }
        .footer { display:flex; justify-content: space-between; align-items: flex-end; margin-top: 28px; }
        .sign { text-align:center; }
        .sign img { height:48px; }
        .stamp img { height:70px; opacity:0.85; }
        .small { font-size:11px; color:#777; margin-top:8px; }
        .tracking { font-size:12px; color:#555; }
    </style>
    <title>Shipment Receipt - Hybreed Courier Trackr</title>
    </head>
    <body>
        <div class="receipt">
            <div class="header">
                <div>'.$brandHtml.'<div class="tracking">Tracking No: <strong>'.htmlspecialchars($data['tracking_number']).'</strong></div></div>
                <div class="meta">Generated: '.$createdDate.' '.$createdTime.'</div>
            </div>
            <div class="title">Shipment Receipt</div>

            <div class="columns">
                <div class="col">
                    <div class="section-title">Sender</div>
                    <div>'.htmlspecialchars($data['sender_name']).'</div>
                    <div class="subtle">'.htmlspecialchars($data['sender_address']).'</div>
                    <div class="subtle">'.htmlspecialchars($data['sender_email']).' · '.htmlspecialchars($data['sender_contact']).'</div>
                </div>
                <div class="col">
                    <div class="section-title">Receiver</div>
                    <div>'.htmlspecialchars($data['receiver_name']).'</div>
                    <div class="subtle">'.htmlspecialchars($data['receiver_address']).'</div>
                    <div class="subtle">'.htmlspecialchars($data['receiver_email']).' · '.htmlspecialchars($data['receiver_contact']).'</div>
                </div>
            </div>

            <table class="grid">
                <tr><th>Parcel Description</th><td>'.htmlspecialchars($data['pdesc']).'</td></tr>
                <tr><th>Status</th><td>'.htmlspecialchars($data['status']).'</td></tr>
                <tr><th>Dispatch Location</th><td>'.htmlspecialchars($data['dispatch_location']).'</td></tr>
                <tr><th>Dispatch Date</th><td>'.htmlspecialchars($data['dispatch_date']).'</td></tr>
                <tr><th>Estimated Delivery Date</th><td>'.htmlspecialchars($data['delivery_date']).'</td></tr>
                <tr><th>Current Location</th><td>'.htmlspecialchars($data['current_location'] ?: $data['dispatch_location']).'</td></tr>
            </table>

            <div class="section-title" style="margin-top:16px;">Shipment History</div>
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    '.$historyHtml.'
                </tbody>
            </table>
            

            <div class="footer">
    <div class="sign">
        '.($signatureSrc !== '' ? '<img src="'.$signatureSrc.'" style="height:100px; width:auto; max-width:150px;" />' : '').'
        <div class="stamp" style="text-align:center;">
    '.($stampSrc !== '' ? '<img src="'.$stampSrc.'" style="height:80px; width:auto; max-width:150px;" />' : '').'
</div>
</div><div class="small">Authorized Signature</div>
    </div>
    
            
    </body>
    </html>';

        ob_clean();

        $mpdf = new \Mpdf\Mpdf(['format' => 'A4', 'margin_left' => 10, 'margin_right' => 10, 'margin_top' => 10, 'margin_bottom' => 10]);
        $mpdf->WriteHTML($html);
        $file = 'tracking-'.preg_replace('/[^A-Za-z0-9_-]/', '', $data['tracking_number']).'-'.time().'.pdf';
        $action = isset($_GET['action']) ? strtolower(trim($_GET['action'])) : 'download';
        $mode = ($action === 'view' || $action === 'i') ? 'I' : 'D';
        $mpdf->Output($file, $mode);

        }
	}
?>