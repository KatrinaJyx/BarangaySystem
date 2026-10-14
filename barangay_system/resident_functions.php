<?php
/* ---------- RESIDENTS ---------- */
function getAllResidents($pdo){
    $sql = "SELECT r.*, h.household_head
            FROM residents r
            LEFT JOIN households h ON r.household_id = h.household_id
            ORDER BY r.full_name";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
function getResidentById($pdo, $resident_id){
    $stmt = $pdo->prepare("SELECT * FROM residents WHERE resident_id = :id");
    $stmt->execute([':id' => $resident_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function addResident($pdo,$full_name,$age,$gender,$contact,$civil_status,
                     $household_id,$region,$province,$citymun,$barangay){
    $sql = "INSERT INTO residents
        (full_name,age,gender,contact,civil_status,household_id,
         region,province,citymun,barangay)
        VALUES (:full_name,:age,:gender,:contact,:civil_status,:household_id,
                :region,:province,:citymun,:barangay)";
    return $pdo->prepare($sql)->execute([
        ':full_name'=>$full_name, ':age'=>$age, ':gender'=>$gender,
        ':contact'=>$contact, ':civil_status'=>$civil_status,
        ':household_id'=>$household_id, ':region'=>$region,
        ':province'=>$province, ':citymun'=>$citymun, ':barangay'=>$barangay
    ]);
}
function updateResident($pdo,$resident_id,$full_name,$age,$gender,$contact,$civil_status,
                        $household_id,$region,$province,$citymun,$barangay){
    $sql = "UPDATE residents SET
            full_name=:full_name, age=:age, gender=:gender,
            contact=:contact, civil_status=:civil_status,
            household_id=:household_id,
            region=:region, province=:province,
            citymun=:citymun, barangay=:barangay
            WHERE resident_id=:id";
    return $pdo->prepare($sql)->execute([
        ':full_name'=>$full_name, ':age'=>$age, ':gender'=>$gender,
        ':contact'=>$contact, ':civil_status'=>$civil_status,
        ':household_id'=>$household_id, ':region'=>$region,
        ':province'=>$province, ':citymun'=>$citymun, ':barangay'=>$barangay,
        ':id'=>$resident_id
    ]);
}
function deleteResident($pdo, $resident_id){
    $stmt = $pdo->prepare("DELETE FROM residents WHERE resident_id = :id");
    return $stmt->execute([':id' => $resident_id]);
}

/* ---------- HOUSEHOLDS ---------- */
function getAllHouseholds($pdo){
    return $pdo->query("SELECT * FROM households ORDER BY household_head")->fetchAll(PDO::FETCH_ASSOC);
}
function getHouseholdById($pdo, $id){
    $stmt = $pdo->prepare("SELECT * FROM households WHERE household_id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function addHousehold($pdo,$head,$count,$contact,$region,$province,$citymun,$barangay){
    $sql = "INSERT INTO households
        (household_head,member_count,contact,region,province,citymun,barangay)
        VALUES (:h,:c,:co,:r,:p,:cm,:b)";
    return $pdo->prepare($sql)->execute([
        ':h'=>$head, ':c'=>$count, ':co'=>$contact,
        ':r'=>$region, ':p'=>$province, ':cm'=>$citymun, ':b'=>$barangay
    ]);
}
function updateHousehold($pdo,$id,$head,$count,$contact,$region,$province,$citymun,$barangay){
    $sql = "UPDATE households SET
        household_head=:h, member_count=:c, contact=:co,
        region=:r, province=:p, citymun=:cm, barangay=:b
        WHERE household_id=:id";
    return $pdo->prepare($sql)->execute([
        ':h'=>$head, ':c'=>$count, ':co'=>$contact,
        ':r'=>$region, ':p'=>$province, ':cm'=>$citymun, ':b'=>$barangay, ':id'=>$id
    ]);
}
function deleteHousehold($pdo, $id){
    $stmt = $pdo->prepare("DELETE FROM households WHERE household_id = :id");
    return $stmt->execute([':id' => $id]);
}

/* ---------- CLEARANCES ---------- */
function getAllClearances($pdo){
    $sql = "SELECT c.*, r.full_name
            FROM clearances c
            JOIN residents r ON c.resident_id = r.resident_id
            ORDER BY c.date_issued DESC";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
function addClearance($pdo,$resident_id,$purpose,$date_issued,$status){
    $sql = "INSERT INTO clearances (resident_id,purpose,date_issued,status)
            VALUES (:r,:p,:d,:s)";
    return $pdo->prepare($sql)->execute([
        ':r'=>$resident_id, ':p'=>$purpose, ':d'=>$date_issued, ':s'=>$status
    ]);
}
function deleteClearance($pdo, $id){
    $stmt = $pdo->prepare("DELETE FROM clearances WHERE clearance_id = :id");
    return $stmt->execute([':id' => $id]);
}

/* ---------- OFFICIALS ---------- */
function getAllOfficials($pdo){
    return $pdo->query("SELECT * FROM officials ORDER BY position")->fetchAll(PDO::FETCH_ASSOC);
}
?>