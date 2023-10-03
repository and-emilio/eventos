<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;;
use App\Http\Requests\EnrollmentRequest;
use Symfony\Component\HttpFoundation\Response;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Enrollment::all(),
            'status' => 'success',
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EnrollmentRequest $request)
    {
        try {
            Enrollment::create($request->all());
        }catch (\Exception $e){
            return response()->json([
            'message' => $e->getMessage(),
            'status' => 'error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'status' => 'success',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            return response()->json([
                'message' => 'Register not found',
                'status' => 'error',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $enrollment,
            'status' => 'success',
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EnrollmentRequest $request, Enrollment $enrollment)
    {
        try {
            $enrollment->update($request->all());
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'status' => 'success',
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            return response()->json([
                'message' => 'Register not found',
                'status' => 'error',
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $enrollment->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'status' => 'success',
        ], Response::HTTP_ACCEPTED);
    }

    public function getEnrollmentPerPage()
    {
        return response()->json([
            'data' => Enrollment::paginate(10),
            'status' => 'success',
        ], Response::HTTP_OK);
    }

    public function filter(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $qtdPerPage = 10;
            $enrollments = Enrollment::all();
            $qtdEnrollments = 0;
            $qtdPages = 0;
            $orderBy = 'name';
            $orderDirection = 'asc';

            $query = Enrollment::query();

            if ($search = $request->input('search')) {
                if ($search) {
                    $query->where('email', 'like', $search . "%");
                }
            } else {
                return $this->index();
            }

            if ($request->has('order_direction')) {
                $query->orderBy($orderBy, $request->input('order_direction'));
            } else {
                $query->orderBy($orderBy, $orderDirection);
            }

            $enrollments = $query->get();

            $qtdEnrollments = $enrollments->count();
            $qtdPages = ceil($qtdEnrollments / $qtdPerPage);

            if (isset($page) && $page > $qtdPages) {
                return response()->json([
                    'message' => 'Page number not found, maximum number of pages is '.$qtdPages.'.',
                    'status' => 'error',
                ], Response::HTTP_BAD_REQUEST);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'errors',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $enrollments->forPage($page, $qtdPerPage)->values(),
            'message' => [
                'qtdEnrollments' => $qtdEnrollments,
                'page' => $page,
                'lastPage' => $qtdPages
            ],
            'status' => 'success',
        ], Response::HTTP_OK);
    }

    public function getEventsByEmail(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $qtdPerPage = 3;
            $enrollments = Enrollment::all();
            $qtdEnrollments = 0;
            $qtdPages = 0;
            $orderBy = 'name';
            $orderDirection = 'asc';

            $query = Enrollment::query();

            if ($search = $request->input('search')) {
                $query->where('email', '=', $search);
            }

            if ($request->has('order_direction')) {
                $query->orderBy($orderBy, $request->input('order_direction'));
            } else {
                $query->orderBy($orderBy, $orderDirection);
            }

            $enrollments = $query->get();

            $qtdEnrollments = $enrollments->count();
            $qtdPages = ceil($qtdEnrollments / $qtdPerPage);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'errors',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $enrollments->forPage($page, $qtdPerPage)->values(),
            'message' => [
                'qtdEnrollments' => $qtdEnrollments,
                'page' => $page,
                'lastPage' => $qtdPages
            ],
            'status' => 'success',
        ], Response::HTTP_OK);
    }

    public function getEvents(Request $request)
    {
        try {
            $ch = curl_init();

            //$url = 'https://demo.ws.itarget.com.br/event.php';
            $url = 'https://jsonplaceholder.typicode.com/posts';

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                return response()->json(['error' => curl_error($ch)], 500);
            }

            curl_close($ch);

            $data = json_decode($response, true);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $data,
            'status' => 'success',
        ], Response::HTTP_OK);
    }
}
