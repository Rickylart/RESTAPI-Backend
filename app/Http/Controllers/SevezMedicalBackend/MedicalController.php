<?php

namespace App\Http\Controllers\SevezMedicalBackend;

use App\Http\Controllers\Controller;
use App\Jobs\SendReportEmailJob;
use App\Models\MedicalReports;
use App\Models\User;
use Illuminate\Http\Request;

class MedicalController extends Controller
{

    /****
     *
     * Get single user medical data
     * @param UserRequest $user_id
     * @return single user data
     */

    public function getPatientMedicalReport()
    {
        $patientReport = User::find(auth()->user()->id);

        return $patientReport->medicalReports;
    }

    /****
     *
     * Store  user medical data
     * @param UserRequest $request
     * @return response
     */

    public function storeMedicalReport(Request $request)
    {
        try {
            //*******get all checked xray */
            $xrays         = $request->input('xray', []);
            $selectedXrays = implode(', ', $xrays);

            //*******get all checked ultra scan */
            $ultraScan     = $request->input('ultra_scan', []);
            $selectedUScan = implode(', ', $ultraScan);

            //*******store and send email */
            MedicalReports::create([
                'user_id'         => auth()->user()->id,
                'xray'            => $selectedXrays,
                'ultrasound_scan' => $selectedUScan,
                'ct_scan'         => $request->ct_scan,
                'mri'             => $request->mri,
            ]);

            //******Send mail */
            $emailData = [
                'receiver'        => 'peopleoperations@kompletecare.com',
                'patient_name'    => auth()->user()->name,
                'xray'            => $selectedXrays,
                'ultrasound_scan' => $selectedUScan,
                'ct_scan'         => $request->ct_scan,
                'mri'             => $request->mri,
            ];

            $job = new SendReportEmailJob($emailData);

            //*******send mail in queue */
            dispatch($job);

            return response()->json([
                'status'  => true,
                'message' => "Report submitted successfully",
            ], 200);

        } catch (\Throwable $th) {
            //******return the failed response */
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ], 422);
        }

    }

/****
 *
 * delete  user medical data
 * @param $id
 * @return response
 */
    public function deleteMedicalReport($id)
    {
        try {
            //****Delete record with id */
            $find = MedicalReports::find($id);

            if ($find) {
                $find->delete();

                return response()->json([
                    'status'  => true,
                    'message' => "Report deleted submitted successfully",
                ], 200);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => "No data found",
                ], 404);
            }

        } catch (\Throwable $th) {
            //******return the failed response */
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ], 422);
        }

    }

    public function storeGraphQLMedicalReport($rootValue, array $args)
    {
        try {
            $selectedXrays = implode(', ', $args['xray']);
            $selectedUScan = implode(', ', $args['ultrasound_scan']);

            //*******store and send email */
            $storeId = MedicalReports::create([
                'user_id'         => auth()->user()->id,
                'xray'            => $selectedXrays,
                'ultrasound_scan' => $selectedUScan,
                'ct_scan'         => $args['ct_scan'],
                'mri'             => $args['mri'],
            ]);

            //******Send mail */
            $emailData = [
                'receiver'        => 'peopleoperations@kompletecare.com',
                'patient_name'    => auth()->user()->name,
                'xray'            => $selectedXrays,
                'ultrasound_scan' => $selectedUScan,
                'ct_scan'         => $args['ct_scan'],
                'mri'             => $args['mri'],
            ];

            $job = new SendReportEmailJob($emailData);

            //*******send mail in queue */
            dispatch($job);

            //******Return data */
            $returnData = [
                'id'              => $storeId->id,
                'xray'            => $selectedXrays,
                'ultrasound_scan' => $selectedUScan,
                'ct_scan'         => $args['ct_scan'],
                'mri'             => $args['mri'],
            ];

            return $returnData;

        } catch (\Throwable $th) {
            //******return the failed response */
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ], 422);
        }
    }
}
